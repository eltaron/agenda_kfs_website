<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use App\Models\Category;
use Filament\Widgets\ChartWidget;

class MeetingsByCategoryChart extends ChartWidget
{
    protected static ?string $heading = '⭕ توزيع الاجتماعات حسب فئة المنظم';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $categories = Category::withCount('users')->get();
        $meetingCounts = [];
        $labels = [];

        foreach ($categories as $category) {
            $count = Meeting::whereIn('created_by', $category->users->pluck('id'))->count();
            $meetingCounts[] = $count;
            $labels[] = $category->name;
        }

        return [
            'datasets' => [
                [
                    'data' => $meetingCounts,
                    'backgroundColor' => ['#d1a13c', '#22c55e', '#3b82f6', '#ef4444'],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // نوع الرسم (دائرة مفرغة)
    }
}
