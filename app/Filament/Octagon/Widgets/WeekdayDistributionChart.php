<?php

namespace App\Filament\Octagon\Widgets;

use App\Models\Meeting;
use Filament\Widgets\ChartWidget;

class WeekdayDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'توزيع الاجتماعات على أيام الأسبوع';

    protected static ?int $sort = 6;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // ترتيب الأسبوع يبدأ من السبت
        $order = [6 => 'السبت', 0 => 'الأحد', 1 => 'الاثنين', 2 => 'الثلاثاء', 3 => 'الأربعاء', 4 => 'الخميس', 5 => 'الجمعة'];

        $counts = Meeting::pluck('start_at')->countBy(fn ($date) => $date->dayOfWeek);

        return [
            'datasets' => [
                [
                    'label' => 'عدد الاجتماعات',
                    'data' => collect(array_keys($order))->map(fn ($d) => $counts->get($d, 0))->all(),
                    'backgroundColor' => 'rgba(139, 92, 246, 0.25)',
                    'borderColor' => '#8b5cf6',
                    'pointBackgroundColor' => '#8b5cf6',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => array_values($order),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => ['legend' => ['display' => false]],
            'scales' => ['y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]]],
        ];
    }
}
