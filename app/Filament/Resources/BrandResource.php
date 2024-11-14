<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Filament\Resources\BrandResource\RelationManagers;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Set;
use PHPUnit\Framework\Attributes\Group;
use Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    public static function getNavigationGroup(): ?string
    {
        return app()->getLocale() === 'ar' ? "الماركات" : "Brand";  
    }
     
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Section::make('Type Brand')->schema([
                    Section::make([ 

                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('ماركة')
                    ->live( true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->label('التاكيد')
                    ->hint('سيتم توليد هذا الحقل تلقائيًا، ليس عليك كتابة أي شيء هنا'),
                ]) ->columns(2),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('brand')
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ])
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
                Tables\Columns\ImageColumn::make('image'),
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
                //
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

    public static function getRelations(): array
    {
        return [
           
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            // 'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel() :string {
        return app()->getLocale() == 'ar' ? 'ماركه' :'Brand';
    }
}
