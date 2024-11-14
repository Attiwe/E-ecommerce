<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpecialResource\Pages;
use App\Filament\Resources\SpecialResource\RelationManagers;
use App\Models\LoginUser;
use App\Models\Special;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SpecialResource extends Resource
{
    protected static ?string $model = Special::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?int $navigationSort = 5;

    public static function getNavigationGroup(): ?string
    {
        return app()->getLocale() === 'ar' ? "الرسم الخاص بالمستخدم" : "Special";  
    }
     
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Section::make('###')->schema([
                        Select::make('login_id')
                    ->label('مالك المنتج')
                        ->options(LoginUser::all()->mapWithKeys(function($user) {
                            return [$user->id => "{$user->first_name} {$user->last_name}"];  
                        }))
                        ->required(),
        
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('اسم المنتج')
                        ->maxLength(255),
                    ])->columns(2),
    
                     Section::make([
                        Forms\Components\Select::make('size')
                        ->required()
                        ->label('المقسات')
                        ->options([
                            'L' => 'L',
                            'XL' => 'XL',
                            'XXL' => 'XXL',
                        ]),
         
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->label('السعر')
                        ->nullable()  
                        ->prefix('$'),
        
                    Forms\Components\TextInput::make('discount')
                        ->required()
                        ->label('الخصم')
                        ->nullable(),
        
                    Forms\Components\TextInput::make('quantity')
                        ->required()
                        ->label('العدد')
                        ->numeric(),
        
                    Forms\Components\TextInput::make('rating')
                        ->required()
                        ->label('التقيم')
                        ->numeric(),
                        Forms\Components\Toggle::make('status')
                        ->label('الحاله')
                        ->required(),
                     ])->columns(2),
    
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label('صوره المنتج')
                    ->required(),
                 ])
            ]);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('size')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSpecials::route('/'),
            'create' => Pages\CreateSpecial::route('/create'),
            'edit' => Pages\EditSpecial::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel():string{
        return app()->getLocale() =='ar' ? 'الرسم الابدعي' : 'Special';
    }
}
