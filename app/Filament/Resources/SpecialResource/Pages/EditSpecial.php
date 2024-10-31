<?php

namespace App\Filament\Resources\SpecialResource\Pages;

use App\Filament\Resources\SpecialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpecial extends EditRecord
{
    protected static string $resource = SpecialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
