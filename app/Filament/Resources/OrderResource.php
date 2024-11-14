<?php
namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
 use Filament\Forms\Components\Select;
 use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
 use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
 use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Number;
 use Filament\Forms\Components\Section;
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
  
 
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $recordTitleAttribute = 'first_name';//searsh

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->first_name;
    }
    protected static ?int $navigationSort = 4;
    public static function getNavigationGroup(): ?string
    {
        return app()->getLocale() === 'ar' ? "الطلبات" : "Orders";  
    }
     
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                               
                            Section::make('معلومات العميل')->schema([
                                TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->tel()
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('country')
                                    ->nullable()
                                    ->default('Egypt'),
                                Textarea::make('address')
                                    ->required(),
                                Toggle::make('status')
                                    ->required(),
                            ])->columns(2),
                Section::make('Order Items')->schema([
                    Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Select::make('product_id')
                                ->relationship('producte', 'name')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->distinct()
                                ->columnSpan(4)
                                ->reactive()
                                ->afterStateUpdated(fn($state, Set $set) =>
                                    $set('unit_amount', Product::find($state)?->price ?? 0)
                                )
                                ->afterStateUpdated(fn($state, Set $set) =>
                                    $set('total_amount', Product::find($state)?->price ?? 0)
                                ),
                            
                            TextInput::make('quantity')
                                ->numeric()
                                ->minValue(1)
                                ->default(1)
                                ->required()
                                ->columnSpan(3)
                                ->reactive()
                                ->afterStateUpdated(fn($state, Set $set, Get $get) =>
                                    $set('total_amount', $state * $get('unit_amount'))
                                ),
                            
                            TextInput::make('unit_amount')
                                ->numeric()
                                ->required()
                                ->disabled()
                                ->dehydrated()
                                ->columnSpan(3),
                            
                            TextInput::make('total_amount')
                                ->numeric()
                                ->dehydrated()
                                ->required()
                                ->columnSpan(2),
                        ])->columns(12),
                ]),

                 Section::make('Totals')->schema([
                    Placeholder::make('groud_total_placeholder')
                        ->label('Money Totals')
                        ->content(function(Get $get, Set $set) {
                            $total = 0;

                             if (!$repeaters = $get('items')) {
                                return $total;  
                            }

                             foreach ($repeaters as $key => $repeater) {
                                $total += $get("items.{$key}.total_amount");
                            }
                            $set('grand_total', $total);
                            return Number::currency($total, 'EGP');
                        }),
                    
                    Hidden::make('grand_total')
                        ->default(0),
                ]),
            ]); 
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')
                    ->rowIndex()
                ,
    
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('country')
                    ->label('Country')
                    ->searchable(),
    
                Tables\Columns\TextColumn::make('address')
                    ->label('Address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
    
                Tables\Columns\IconColumn::make('status')
                    ->boolean()
                    ->label('Status'),
    
                
    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([

             ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
   
    public static function getNavigationBadge() :?string{  
        return static::getModel()::count();
    } 
     
    public static function getNavigationBadgeColor() : string|array|null{
        return static::getModel()::count() >10 ? 'danger' : 'success';
    }



    public static function getRelations(): array
    {
        return [
         ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel():string{
        return app()->getLocale() =='ar' ? 'الطلبات' : 'Orders';
    }
}
