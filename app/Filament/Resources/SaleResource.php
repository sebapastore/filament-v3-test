<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Models\Item;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Header')
                    ->collapsible()
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->maxDate(now()),
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->required(),

                ]),

                Forms\Components\Section::make('Items')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Repeater::make('details')
                            ->schema([
                                Forms\Components\TextInput::make('quantity')
                                    ->numeric()
                                    ->required()
                                    ->live(),
                                Forms\Components\Select::make('item_id')
                                    ->getSearchResultsUsing(fn (string $search): array => Item::query()->where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                                    ->getOptionLabelUsing(fn ($value): ?string => Item::query()->find($value)?->name)
                                    ->searchable()
                                    ->required(),
                                Forms\Components\Placeholder::make('price')
                                    ->content(function (Forms\Get $get) {
                                        $price = Item::query()->find($get('item_id'))?->price;
                                        $quantity = \intval($get('quantity'));
                                        return $price * $quantity;
                                        // Use $get('products') to get an array of items.
                                        // Loop through each item and make a total
                                        // Return the total from this function
                                    }),
                        ])->columns(3)
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
