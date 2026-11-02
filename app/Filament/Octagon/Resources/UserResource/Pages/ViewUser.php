<?php

namespace App\Filament\Octagon\Resources\UserResource\Pages;

use App\Filament\Octagon\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
