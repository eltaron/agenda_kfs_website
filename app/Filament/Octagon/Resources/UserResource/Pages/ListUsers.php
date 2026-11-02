<?php

namespace App\Filament\Octagon\Resources\UserResource\Pages;

use App\Filament\Octagon\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
