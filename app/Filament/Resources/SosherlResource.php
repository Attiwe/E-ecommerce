<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SosherlResource\Pages;
use App\Filament\Resources\SosherlResource\RelationManagers;
use App\Models\Sosherl;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Markdown;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SosherlResource extends Resource
{
    protected static ?string $model = Sosherl::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    public static function getNavigationGroup(): ?string
    {
        return app()->getLocale() === 'ar' ? "المستخدمين" : "Users";  
    }
     

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make("info")->schema([
                Section::make([
                    TextInput::make('name')
                        ->label('اسم الموقع')
                        ->required(),
                    TextInput::make('phone')
                        ->label('التلفون')
                        ->required(),
                    TextInput::make('email')
                        ->label('الايميل')
                        ->required(),
                ])->columns(3),
                Section::make('المديا')->schema([
                    TextInput::make('sosherl')
                        ->label('لنكات التواصل')
                        ->url()  
                        ->required(),
                ]),
                Textarea::make('disc')
                    ->label('وصف الموقع')
                    ->required(),
            ]),
        ]);
}


  
public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('#')->rowIndex(),
            TextColumn::make('name')
                ->label('اسم الموقع')
                ->sortable()
                ->searchable(),
                
            TextColumn::make('phone')
                ->label('التلفون')
                ->sortable()
                ->searchable(),
                
            TextColumn::make('email')
                ->label('الايميل')
                ->sortable()
                ->searchable(),
                
            TextColumn::make('sosherl')
                ->label('لنكات التواصل')
                ->searchable(),  

            TextColumn::make('disc')
                ->label('وصف الموقع')
                ->limit(100) 
                ->sortable(),
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
            Tables\Actions\ActionGroup::make(actions: [
     
            Tables\Actions\EditAction::make(),
            Tables\Actions\ViewAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
            ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSosherls::route('/'),
            'create' => Pages\CreateSosherl::route('/create'),
            //'edit' => Pages\EditSosherl::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel():string{
        return app()->getLocale() =='ar' ? ' التوصل ' : 'Soshel';
    }
}

