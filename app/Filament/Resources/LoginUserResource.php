<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoginUserResource\Pages;
use App\Filament\Resources\LoginUserResource\RelationManagers;
use App\Models\LoginUser;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoginUserResource extends Resource
{
    protected static ?string $model = LoginUser::class;
 
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';
    public static function getNavigationGroup(): ?string
    {
        return app()->getLocale() === 'ar' ? "المستخدمين" : "Users";  
    }
 
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('user_id')
                //     ->required()
                //     ->numeric(),
                Section::make()->schema([ 
               Section::make([
                Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
               ])->columns(2),
               Section::make([
                Forms\Components\TextInput::make('phone')
                ->tel()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
               ])->columns(2),
                Section::make([
                    Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                    Forms\Components\TextInput::make('country')
                    ->maxLength(255)
                    ->default('--'),
                
                ])->columns(2),
                Forms\Components\Toggle::make('status')
                    ->required(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('#')
                ->rowIndex(),
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoginUsers::route('/'),
            'create' => Pages\CreateLoginUser::route('/create'),
            // 'edit' => Pages\EditLoginUser::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel():string{
        return app()->getLocale() =='ar' ? 'تسجيل علي الموقع' : 'LoginUser';
    }
    public static function getNavigationBadge() :?string{  
        return static::getModel()::count();
    } 
     
    public static function getNavigationBadgeColor() : string|array|null{
        return static::getModel()::count() >10 ? 'danger' : 'success';
    }

}
