<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceLogResource\Pages;
use App\Models\AttendanceLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\AttendanceType;
use Coolsam\FilamentFlatpickr\Forms\Components\Flatpickr;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Filament\Tables\Filters\SelectFilter;

class AttendanceLogResource extends Resource
{
    protected static ?string $model = AttendanceLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Flatpickr::make('log_time')
                    ->allowInput()
                    ->enableTime()
                    ->minuteIncrement(1)
                    ->minDate(Carbon::today())
                    ->minTime(Carbon::now('Asia/Ho_Chi_Minh')->format('h:i:s A'))
                    ->visibleOn('create'),
                Flatpickr::make('log_time')
                    ->allowInput()
                    ->enableTime()
                    ->minuteIncrement(1)
                    ->visibleOn('edit'),
                Forms\Components\Select::make('log_type')
                    ->options(AttendanceType::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('log_time')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('log_type'),
            ])
            ->filters([
                SelectFilter::make('log_type')
                    ->options(AttendanceType::class)
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
            'index' => Pages\ListAttendanceLogs::route('/'),
            // 'create' => Pages\CreateAttendanceLog::route('/create'),
            // 'edit' => Pages\EditAttendanceLog::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->hasRole('super_admin')) {
            return parent::getEloquentQuery();
        }
        return parent::getEloquentQuery()->whereBelongsTo(auth()->user());
    }
}
