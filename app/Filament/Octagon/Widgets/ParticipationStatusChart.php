<?php

namespace App\Filament\Octagon\Widgets;

use App\Filament\Octagon\Concerns\MeetingStatus;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ParticipationStatusChart extends ChartWidget
{
    protected static ?string $heading = 'حالة الدعوات';

    protected static ?string $description = 'توزيع ردود المدعوين على الاجتماعات';

    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $counts = DB::table('meeting_user')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $labels = MeetingStatus::participantStatusLabels();
        $colors = ['pending' => '#f59e0b', 'attending' => '#22c55e', 'declined' => '#ef4444'];

        $data = [];
        $bg = [];
        foreach ($labels as $key => $label) {
            $data[] = (int) ($counts[$key] ?? 0);
            $bg[] = $colors[$key];
        }

        return [
            'datasets' => [
                ['data' => $data, 'backgroundColor' => $bg],
            ],
            'labels' => array_values($labels),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
