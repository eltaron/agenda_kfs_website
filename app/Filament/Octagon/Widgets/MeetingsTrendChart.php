<?php

namespace App\Filament\Octagon\Widgets;

use App\Models\Meeting;
use Filament\Widgets\ChartWidget;

class MeetingsTrendChart extends ChartWidget
{
    protected static ?string $heading = 'الاجتماعات الشهرية';

    protected static ?string $description = 'عدد الاجتماعات في كل شهر خلال السنة المختارة';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $maxHeight = '320px';

    public ?string $filter = null;

    public function mount(): void
    {
        $this->filter ??= (string) now()->year;
        parent::mount();
    }

    protected function getFilters(): ?array
    {
        $years = Meeting::query()
            ->pluck('start_at')
            ->map(fn ($date) => $date->year)
            ->push(now()->year)
            ->unique()
            ->sortDesc()
            ->values();

        return $years->mapWithKeys(fn ($year) => [(string) $year => (string) $year])->all();
    }

    protected function getData(): array
    {
        $year = (int) ($this->filter ?: now()->year);
        $now = now();

        $meetings = Meeting::whereYear('start_at', $year)->get(['start_at', 'end_at']);

        $total = array_fill(1, 12, 0);
        $archived = array_fill(1, 12, 0);

        foreach ($meetings as $meeting) {
            $month = $meeting->start_at->month;
            $total[$month]++;
            if ($meeting->end_at && $meeting->end_at->lt($now)) {
                $archived[$month]++;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'إجمالي الاجتماعات',
                    'data' => array_values($total),
                    'backgroundColor' => 'rgba(209, 161, 60, 0.85)',
                    'borderColor' => '#d1a13c',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'مؤرشفة (منتهية)',
                    'data' => array_values($archived),
                    'backgroundColor' => 'rgba(100, 116, 139, 0.6)',
                    'borderColor' => '#64748b',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]],
            ],
        ];
    }
}
