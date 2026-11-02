<?php

namespace App\Filament\Octagon\Resources\MeetingResource\Pages;

use App\Filament\Octagon\Resources\MeetingResource;
use Filament\Resources\Pages\ViewRecord;

class ViewMeeting extends ViewRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
