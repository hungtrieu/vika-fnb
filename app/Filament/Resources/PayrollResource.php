<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PayrollResource\Pages;
use App\Filament\Resources\PayrollResource\RelationManagers;
use App\Models\Payroll;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Carbon\Carbon;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PayrollResource extends Resource
{
    protected static ?string $model = Payroll::class;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';

    protected static ?int $navigationSort = 200;

    public static function getNavigationLabel(): string
    {
        return __('Payroll');
    }

    public static function getModelLabel(): string
    {
        return __('Payroll');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label(__('Name'))
                    ->required()
                    ->options(User::where('store_id', auth()->user()->store_id)->get()->pluck('name', 'id')->toArray()),
                Flatpickr::make('pay_date')->label(__('Pay Date'))
                    ->allowInput()
                    ->maxDate(Carbon::today())
                    ->required(),
                Forms\Components\TextInput::make('salary')->label(__('Salary'))
                    ->required()
                    ->live()
                    ->prefix(config('app.currency_unit'))
                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                        $set('net_salary', $state - $get('deductions'));
                    }),
                Forms\Components\TextInput::make('deductions')->label(__('Deductions'))
                    ->prefix(config('app.currency_unit'))
                    ->live()
                    ->afterStateUpdated(function ($state, Get $get, Set $set) {
                        $set('net_salary', $get('salary') - $state);
                    }),
                Forms\Components\TextInput::make("net_salary")->label(__('Net Salary'))
                    ->prefix(config('app.currency_unit')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label(__('Name'))->searchable(),
                Tables\Columns\TextColumn::make('store.name')->label(__('Store'))
                    ->visible(auth()->user()->hasRole('super_admin')),
                Tables\Columns\TextColumn::make('pay_date')->label(__('Pay Date'))->datetime('d-m-Y'),
                Tables\Columns\TextColumn::make('salary')->label(__('Salary')),
                Tables\Columns\TextColumn::make('deductions')->label(__('Deductions')),
                Tables\Columns\TextColumn::make('net_salary')->label(__('Net Salary')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePayrolls::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }
        return parent::getEloquentQuery()->where('store_id', auth()->user()->store_id);
    }

}
