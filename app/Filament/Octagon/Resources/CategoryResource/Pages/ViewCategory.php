<?php

namespace App\Filament\Octagon\Resources\CategoryResource\Pages;

use App\Filament\Octagon\Resources\CategoryResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCategory extends ViewRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
