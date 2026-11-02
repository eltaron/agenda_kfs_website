<?php

namespace App\Filament\Octagon\Resources\AttachmentResource\Pages;

use App\Filament\Octagon\Resources\AttachmentResource;
use Filament\Resources\Pages\ListRecords;

class ListAttachments extends ListRecords
{
    protected static string $resource = AttachmentResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
