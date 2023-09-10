<?php

namespace App\Filament\Resources\MenuResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Menu Item');
    }

    public static function getModelLabel(): string
    {
        return __('Menu Item');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('Name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')->label(__('Image'))
                    ->image()
                    ->directory('menu-items')
                    ->preserveFilenames()
                    ->maxSize(2048)
                    ->required(),
                Forms\Components\TextInput::make('original_price')->label(__('Original Price'))
                    ->numeric()
                    ->prefix(config('app.currency_unit')),
                Forms\Components\TextInput::make('price')->label(__('Price'))
                    ->required()
                    ->numeric()
                    ->prefix(config('app.currency_unit')),
                Forms\Components\Toggle::make('status')->label(__('Status'))
                    ->required()
                    ->default('checked'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(__('Image')),
                Tables\Columns\TextColumn::make('name')->label(__('Name')),
                Tables\Columns\TextColumn::make('original_price')->label(__('Original Price'))->numeric()->prefix(config('app.currency_unit')),
                Tables\Columns\TextColumn::make('price')->label(__('Price'))->numeric()->prefix(config('app.currency_unit')),
                Tables\Columns\ToggleColumn::make('status')->label(__('Status'))
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
