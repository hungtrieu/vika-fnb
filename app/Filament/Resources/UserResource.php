<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use App\Models\Store;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 99;

    public static function getNavigationLabel(): string
    {
        return __('User');
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')->label(__('Password'))
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->minLength(8)
                    ->password()
                    ->same('passwordConfirmation')
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Forms\Components\TextInput::make('passwordConfirmation')
                    ->label(__('Password Confirmation'))
                    ->password()
                    ->required(fn(Page $livewire): bool => $livewire instanceof CreateRecord)
                    ->minLength(8)
                    ->dehydrated(false),
                Forms\Components\Select::make('store_id')
                    ->options(Store::all()->pluck('name', 'id')->toArray())
                    ->required()
                    ->label(__('Store'))
                    ->visible(auth()->user()->hasRole('super_admin')),
                Forms\Components\Select::make('roles')->label(__('Role'))
                    ->multiple()->relationship('roles', 'name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name'))
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('store.name')->label(__('Store'))
                    ->visible(auth()->user()->hasRole('super_admin')),
                Tables\Columns\TextColumn::make('roles.name')->label(__('Role')),
                Tables\Columns\TextColumn::make('created_at')->label(__('Created at')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
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
