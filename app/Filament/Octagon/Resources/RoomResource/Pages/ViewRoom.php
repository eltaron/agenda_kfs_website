<?php

namespace App\Filament\Octagon\Resources\RoomResource\Pages;

use App\Filament\Octagon\Resources\RoomResource;
use Filament\Resources\Pages\ViewRecord;

class ViewRoom extends ViewRecord
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
