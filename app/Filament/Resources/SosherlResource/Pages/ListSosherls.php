<?php

namespace App\Filament\Resources\SosherlResource\Pages;

use App\Filament\Resources\SosherlResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSosherls extends ListRecords
{
    protected static string $resource = SosherlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
