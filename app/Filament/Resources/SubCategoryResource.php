<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubCategoryResource\Pages;
use App\Filament\Resources\SubCategoryResource\RelationManagers;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;
use Filament\Forms\Set;

class SubCategoryResource extends Resource
{
    protected static ?string $model = SubCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('اختيار النوع')->schema([ 
               Section::make('الاقسام')->schema([
                Select::make('categre_id')
                ->relationship('categres', 'name')  
                ->required(),
               ]),
               Section::make([
                Forms\Components\TextInput::make('name')
                ->label('الفئه')
                ->required()
               ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                 ->maxLength(255),
          
                 Forms\Components\TextInput::make('slug')
                ->required()
                ->label('التاكيد')
                ->hint('سيتم توليد هذا الحقل تلقائيًا، ليس عليك كتابة أي شيء هنا'),
                ])->columns(2),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('SubCategory')
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
                Tables\Columns\TextColumn::make('categres.name')
                     
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                  
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                    Tables\Columns\ImageColumn::make('image')
                    ->rounded(),

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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListSubCategories::route('/'),
            'create' => Pages\CreateSubCategory::route('/create'),
            // 'edit' => Pages\EditSubCategory::route('/{record}/edit'),
        ];
    }
}
