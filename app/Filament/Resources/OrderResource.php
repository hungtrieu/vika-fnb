<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\CulinaryTable;
use App\Models\Floor;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Illuminate\Support\Collection;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Enums\OrderStatuses;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(20)
                    ->default(Order::generateCode()),

                Forms\Components\Select::make('floor_id')
                    ->options(Floor::all()->pluck('name', 'id')->toArray())
                    ->label('Floor')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('culinary_table_id', null)),
                 
                Forms\Components\Select::make('culinary_table_id')
                    ->options(function (callable $get) {
                        $floor = Floor::find($get('floor_id'));

                        if(!$floor) {
                            return CulinaryTable::all()->pluck('name', 'id');
                        }

                        return $floor->culinary_tables->pluck('name', 'id');
                        
                    })
                    ->label('Table')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options(OrderStatuses::class)
                    ->required(),
                Forms\Components\Hidden::make('user_id')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code'),
                Tables\Columns\TextColumn::make('floor.name')
                    ->label('Floor'),
                Tables\Columns\TextColumn::make('culinary_table.name')
                    ->label('Table'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User'),
                Tables\Columns\SelectColumn::make('status')
                    ->options(OrderStatuses::class),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
