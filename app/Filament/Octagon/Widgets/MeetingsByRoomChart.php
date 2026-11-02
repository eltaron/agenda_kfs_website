<?php

namespace App\Filament\Octagon\Widgets;

use App\Models\Room;
use Filament\Widgets\ChartWidget;

class MeetingsByRoomChart extends ChartWidget
{
    protected static ?string $heading = 'استخدام القاعات';

    protected static ?string $description = 'عدد الاجتماعات في كل قاعة';

    protected static ?int $sort = 5;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $rooms = Room::withCount('meetings')->orderByDesc('meetings_count')->get();

        return [
            'datasets' => [
                [
                    'label' => 'عدد الاجتماعات',
                    'data' => $rooms->pluck('meetings_count')->all(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.75)',
                    'borderColor' => '#3b82f6',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $rooms->pluck('name')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins' => ['legend' => ['display' => false]],
            'scales' => ['x' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]]],
        ];
    }
}
