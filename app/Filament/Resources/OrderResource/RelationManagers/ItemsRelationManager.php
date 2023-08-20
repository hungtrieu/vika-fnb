<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Menu;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enums\OrderStatuses;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('menu_id')
                    ->options(Menu::all()->pluck('name', 'id')->toArray())
                    ->label('Menu')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('menu_item_id', null)),
                 
                Forms\Components\Select::make('menu_item_id')
                    ->options(function (callable $get) {
                        $menu = Menu::find($get('menu_id'));

                        if(!$menu) {
                            return MenuItem::all()->pluck('name', 'id');
                        }

                        return $menu->items->pluck('name', 'id');
                    })
                    ->label('Menu item')
                    ->required(),
                    Forms\Components\TextInput::make('quantity')
                        ->required()
                        ->numeric(),
                Forms\Components\Select::make('status')
                    ->options(OrderStatuses::class)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('menu.name')
                    ->label('Menu'),
                Tables\Columns\TextColumn::make('menu_item.name')
                    ->label('Menu item'),
                Tables\Columns\TextInputColumn::make('quantity')
                    ->rules(['numeric']),
                Tables\Columns\SelectColumn::make('status')
                    ->options(OrderStatuses::class),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
