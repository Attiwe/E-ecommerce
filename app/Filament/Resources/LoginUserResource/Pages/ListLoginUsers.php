<?php

namespace App\Filament\Resources\LoginUserResource\Pages;

use App\Filament\Resources\LoginUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoginUsers extends ListRecords
{
    protected static string $resource = LoginUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
