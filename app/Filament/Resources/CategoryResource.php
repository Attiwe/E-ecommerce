<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use PhpParser\Node\Stmt\Label;
use Str;
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationGroup = 'Category';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';//searsh

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->name;
    }
    public static function getNavigationGroup(): ?string
    {
        return app()->getLocale() === 'ar' ? "الاقسام" : "Category";  
    }
     
    
    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               Card::make('الفئات')->schema([
                Forms\Components\TextInput::make('name')
                ->required()
 
                ->label('الفسم')
                 ->live( true)
                 ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                ->maxLength(255),
                TextInput::make('slug')
                ->label('التاكيد')
                ->hint('سيتم توليد هذا الحقل تلقائيًا، ليس عليك كتابة أي شيء هنا'),

                Select::make('subcategory_id')
                        ->relationship('subcategor', 'name')
                        ->label('الفئة الفرعية')
                        ->nullable(),
                Forms\Components\Toggle::make('status')
                ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('#')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('subcategor.name')
                    ->label('الفئة الفرعية')
                    ->searchable(),
                       
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
               
            ])
            ->actions([
 
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),

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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            // 'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel():string{
        return app()->getLocale() =='ar' ? 'الفئات ' : 'Category';
    }
}
