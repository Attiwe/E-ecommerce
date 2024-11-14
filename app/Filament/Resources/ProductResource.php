<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use Str;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $recordTitleAttribute = 'name';//searsh

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    public static function getNavigationGroup(): ?string
    {
        return app()->getLocale() === 'ar' ? "المنتجات" : "Product";  
    }
     
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('معلومات المنتج')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->live(true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط الثابت')
                            ->required()
                            ->hint('سيتم توليد هذا الحقل تلقائيًا، ليس عليك كتابة أي شيء هنا'),
                    ])->columns(2),

                Section::make('التصنيف والعلامة التجارية')
                    ->schema([
                        Forms\Components\Select::make('Categore_id')
                            ->label('التصنيف')
                            ->relationship('categore', 'name')
                            ->required(),

                        Forms\Components\Select::make('subcategory_id')
                            ->label('التصنيف الفرعي')
                            ->preload()
                            ->options(SubCategory::all()->pluck('name', 'id'))
                            ->required(),

                        Forms\Components\Select::make('brand_id')
                            ->label('العلامة التجارية')
                            ->relationship('brand', 'name')
                            ->preload()
                            ->required(),
                    ])->columns(2),

                Section::make('المواصفات')
                    ->schema([
                        Forms\Components\Select::make('color')
                            ->label('اللون')
                            ->options([
                                'الأحمر' => 'الأحمر',
                                'أبيض' => 'أبيض',
                                'أصفر' => 'أصفر',
                                'أخضر' => 'أخضر',
                                'الاسود' => 'الاسود',
                                'غير ذلك' => 'غير ذلك',
                            ])
                            ->required(),

                        Forms\Components\Select::make('size')
                            ->label('المقاس')
                            ->options([
                                'L' => 'L',
                                'XL' => 'XL',
                                'XXL' => 'XXL',
                                'منتج اخر' => 'منتج اخر',
                            ]),

                        Forms\Components\TextInput::make('rating')
                            ->label('التقييم')
                            ->default(1)
                            ->numeric(),
                    ])->columns(2),

                Section::make('السعر والخصم')
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('الكمية')
                            ->required()
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $finalPrice = $get('final_price') ?: 0;
                                $quantity = $get('quantity') ?: 1;
                                $totalPrice = $finalPrice * $quantity;
                                $set('total_price', round($totalPrice, 2));
                            }),

                        Forms\Components\TextInput::make('price')
                            ->label('السعر')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $price = $get('price') ?: 0;
                                $discount = $get('discount') ?: 0;
                                $finalPrice = $price - ($price * ($discount / 100));
                                $set('final_price', round($finalPrice, 2));
                                $quantity = $get('quantity') ?: 1;
                                $totalPrice = $finalPrice * $quantity;
                                $set('total_price', round($totalPrice, 2));
                            }),

                        Forms\Components\TextInput::make('discount')
                            ->label('الخصم')
                            ->numeric()
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, callable $get) {
                                $price = $get('price') ?: 0;
                                $discount = $get('discount') ?: 0;
                                $finalPrice = $price - ($price * ($discount / 100));
                                $set('final_price', round($finalPrice, 2));
                                $quantity = $get('quantity') ?: 1;
                                $totalPrice = $finalPrice * $quantity;
                                $set('total_price', round($totalPrice, 1));
                            }),

                        Forms\Components\TextInput::make('total_price')
                            ->label('السعر الإجمالي بعد الخصم')
                            ->numeric()
                            ->disabled()
                            ->reactive(),
                    ])->columns(2),

                Section::make('الوصف')
                    ->schema([
                        Forms\Components\MarkdownEditor::make('description')
                            ->label('الوصف')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('الصورة والحالة')
                    ->schema([
                        FileUpload::make('images')
                        ->multiple()
                        ->maxFiles(5)
                        ->directory('products')
                        ->reorderable(),

                        Forms\Components\Toggle::make('status')
                            ->label('الحالة')
                            ->required(),
                    ]),
            ]);
    }
 // In ProductResource.php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('#')
            ->rowIndex(),

            Tables\Columns\TextColumn::make('categore.name')
                ->sortable(),
            Tables\Columns\TextColumn::make('brand.name')
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\TextColumn::make('color')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            Tables\Columns\TextColumn::make('size')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            Tables\Columns\TextColumn::make('slug')
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
            Tables\Columns\TextColumn::make('quantity')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('rating')
                ->numeric()
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable(),
            Tables\Columns\TextColumn::make('price')
                ->label('السعر')
                ->numeric()
                ->prefix('$')
                ->sortable(),
            Tables\Columns\TextColumn::make('discount')
                ->label('الخصم')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('total_price')
                ->label('السعر الإجمالي بعد الخصم')
                ->numeric()
                ->sortable(),
            // Tables\Columns\ImageColumn::make('image'),
            Tables\Columns\IconColumn::make('status')
                ->boolean(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            SelectFilter::make('المنتجات')
            ->relationship('categore','name'),
            SelectFilter::make('الماركات')
            ->relationship('brand','name'),

            ])
            ->actions([
                Tables\Actions\ActionGroup::make(actions: [

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),

            ])  
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
           // 'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel():string{
        return app()->getLocale() =='ar' ? 'المنتجات ' : 'Product';
    }
}
