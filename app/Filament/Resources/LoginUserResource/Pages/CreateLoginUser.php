<?php

namespace App\Filament\Resources\LoginUserResource\Pages;

use App\Filament\Resources\LoginUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoginUser extends CreateRecord
{
    protected static string $resource = LoginUserResource::class;
}
