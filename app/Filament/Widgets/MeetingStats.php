<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use App\Models\User;
use App\Models\Room;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MeetingStats extends BaseWidget
{
    protected static ?int $sort = 1; // ترتيب الظهور

    protected function getStats(): array
    {
        return [
            Stat::make('إجمالي الاجتماعات', Meeting::count())
                ->description('منذ بداية المنظومة')
                ->descriptionIcon('heroicon-m-presentation-chart-bar')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),

            Stat::make('اجتماعات اليوم', Meeting::whereDate('start_at', today())->count())
                ->description('اجتماعات مجدولة اليوم')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),

            Stat::make('المستخدمين النشطين', User::count())
                ->description('موظفين مسجلين بالمنظومة')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('القاعات المتاحة', Room::where('is_active', true)->count())
                ->description('قاعات جاهزة للاستخدام')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('info'),
        ];
    }
}
