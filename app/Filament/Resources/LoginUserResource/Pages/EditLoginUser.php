<?php

namespace App\Filament\Resources\LoginUserResource\Pages;

use App\Filament\Resources\LoginUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoginUser extends EditRecord
{
    protected static string $resource = LoginUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
