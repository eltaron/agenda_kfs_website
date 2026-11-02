<?php

namespace App\Filament\Octagon\Resources\RoomResource\Pages;

use App\Filament\Octagon\Resources\RoomResource;
use Filament\Resources\Pages\ListRecords;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
