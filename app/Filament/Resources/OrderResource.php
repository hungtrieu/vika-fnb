<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\CulinaryTable;
use App\Models\Floor;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Forms\Components\Section;
use Illuminate\Support\Collection;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Enums\OrderStatuses;
use App\Enums\OrderItemStatuses;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Section::make('Information')
                    ->columns(5)
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
                        Forms\Components\TextInput::make("amount")
                            ->readOnly(),
                            // ->default(0)
                            // ->placeholder(function (Get $get, Set $set) {
                            //     return self::calculateOrderAmount($get, $set);
                            // }),
                        Forms\Components\Hidden::make('user_id'),
                    ]),
                Section::make()
                    ->visibleOn('edit')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->columns(6)
                            ->addActionLabel('Add order item')
                            ->visibleOn('edit')
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
                                    ->reactive()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $item = MenuItem::find($get('menu_item_id'));

                                        $price = 0;

                                        if($item) {
                                            $price = $item->price;
                                        }

                                        $set('price', $price);

                                        $set('amount', $get('price') * $get('quantity'));

                                        // self::calculateOrderAmount($get, $set);
                                    })
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $set('amount', $get('price') * $get('quantity'));

                                        // self::calculateOrderAmount($get, $set);
                                    })
                                    ->default(0)
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(100),
                                Forms\Components\TextInput::make('price')
                                    ->prefix('$')
                                    ->readOnly()
                                    ->default(0),
                                Forms\Components\TextInput::make('amount')
                                    ->prefix('$')
                                    ->readOnly()
                                    ->default(0),
                                Forms\Components\Select::make('status')
                                    ->options(OrderItemStatuses::class)
                                    ->required(),
                            ])
                    ])
            ]);
    }

    protected static function calculateOrderAmount(Get $get, Set $set) : string {
        $items = $get('items');

        $order_amount = 0;

        foreach ($items as $item) {
            $order_amount += $item['amount'];
        }

        return $order_amount;
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
                Tables\Columns\TextColumn::make('amount'),
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
            // RelationManagers\ItemsRelationManager::class,
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
