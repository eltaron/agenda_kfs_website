<?php

namespace App\Filament\Octagon\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MeetingsByCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'الاجتماعات حسب فئة المنظم';

    protected static ?int $sort = 4;

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $rows = DB::table('meetings')
            ->leftJoin('users', 'users.id', '=', 'meetings.created_by')
            ->leftJoin('categories', 'categories.id', '=', 'users.category_id')
            ->select(DB::raw("COALESCE(categories.name, 'بدون فئة') as category"), DB::raw('count(meetings.id) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $palette = ['#d1a13c', '#22c55e', '#3b82f6', '#ef4444', '#8b5cf6', '#14b8a6', '#f97316', '#64748b'];

        return [
            'datasets' => [
                [
                    'data' => $rows->pluck('total')->map(fn ($v) => (int) $v)->all(),
                    'backgroundColor' => $rows->keys()->map(fn ($i) => $palette[$i % count($palette)])->all(),
                ],
            ],
            'labels' => $rows->pluck('category')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
