<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class MeetingsChart extends ChartWidget
{
    protected static ?string $heading = '📊 معدل الاجتماعات الشهرية';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Meeting::select(DB::raw('count(*) as count'), DB::raw('MONTH(start_at) as month'))
            ->whereYear('start_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // ملء الشهور الفارغة بالأصفار
        $monthlyCounts = array_fill(1, 12, 0);
        foreach ($data as $month => $count) {
            $monthlyCounts[$month] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'الاجتماعات',
                    'data' => array_values($monthlyCounts),
                    'backgroundColor' => '#d1a13c', // لون ذهبي
                    'borderColor' => '#d1a13c',
                ],
            ],
            'labels' => ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // نوع الرسم (أعمدة)
    }
}
