<?php

namespace App\Filament\Resources\SosherlResource\Pages;

use App\Filament\Resources\SosherlResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSosherl extends EditRecord
{
    protected static string $resource = SosherlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
