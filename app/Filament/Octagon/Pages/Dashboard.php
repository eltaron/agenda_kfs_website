<?php

namespace App\Filament\Octagon\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationLabel = 'الإحصائيات';

    protected static ?string $title = 'لوحة Octagon - الإحصائيات العامة';

    public function getColumns(): int | string | array
    {
        return 2;
    }
}
