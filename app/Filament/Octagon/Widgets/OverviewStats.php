<?php

namespace App\Filament\Octagon\Widgets;

use App\Models\Attachment;
use App\Models\Category;
use App\Models\Meeting;
use App\Models\Room;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class OverviewStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected static ?string $pollingInterval = '60s';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $now = now();

        $totalMeetings = Meeting::count();
        $archived = Meeting::where('end_at', '<', $now)->count();
        $upcoming = Meeting::where('start_at', '>', $now)->count();
        $ongoing = Meeting::where('start_at', '<=', $now)->where('end_at', '>=', $now)->count();
        $today = Meeting::whereDate('start_at', today())->count();
        $thisMonth = Meeting::whereBetween('start_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])->count();
        $lastMonth = Meeting::whereBetween('start_at', [$now->copy()->subMonthNoOverflow()->startOfMonth(), $now->copy()->subMonthNoOverflow()->endOfMonth()])->count();

        $invitations = DB::table('meeting_user')->count();
        $attending = DB::table('meeting_user')->where('status', 'attending')->count();
        $declined = DB::table('meeting_user')->where('status', 'declined')->count();
        $attendanceRate = $invitations > 0 ? round($attending / $invitations * 100, 1) : 0;

        $attachmentsCount = Attachment::count();
        $attachmentsSize = (int) Attachment::sum('file_size');

        $monthDiff = $thisMonth - $lastMonth;

        return [
            Stat::make('إجمالي الاجتماعات', number_format($totalMeetings))
                ->description('منذ بداية المنظومة')
                ->descriptionIcon('heroicon-m-presentation-chart-bar')
                ->chart($this->lastMonthsTrend(8))
                ->color('primary'),

            Stat::make('الاجتماعات المؤرشفة', number_format($archived))
                ->description('اجتماعات انتهت ومحفوظة بالأرشيف')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('gray'),

            Stat::make('الاجتماعات القادمة', number_format($upcoming))
                ->description($ongoing > 0 ? "{$ongoing} اجتماع جارٍ الآن" : 'لا يوجد اجتماع جارٍ الآن')
                ->descriptionIcon('heroicon-m-clock')
                ->color('info'),

            Stat::make('اجتماعات اليوم', number_format($today))
                ->description('مجدولة بتاريخ اليوم')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('warning'),

            Stat::make('اجتماعات هذا الشهر', number_format($thisMonth))
                ->description(($monthDiff >= 0 ? '+' : '') . $monthDiff . ' مقارنة بالشهر الماضي')
                ->descriptionIcon($monthDiff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthDiff >= 0 ? 'success' : 'danger'),

            Stat::make('نسبة تأكيد الحضور', $attendanceRate . '%')
                ->description("{$attending} مؤكد / {$declined} معتذر من {$invitations} دعوة")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('المستخدمين', number_format(User::count()))
                ->description(Category::count() . ' فئة')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('القاعات', Room::where('is_active', true)->count() . ' / ' . Room::count())
                ->description('قاعات مفعلة من الإجمالي')
                ->descriptionIcon('heroicon-m-home-modern')
                ->color('info'),

            Stat::make('المرفقات المؤرشفة', number_format($attachmentsCount))
                ->description('الحجم الإجمالي: ' . $this->readableSize($attachmentsSize))
                ->descriptionIcon('heroicon-m-paper-clip')
                ->color('gray'),
        ];
    }

    /**
     * عدد الاجتماعات لكل شهر خلال آخر N شهور (لرسم الخط الصغير).
     */
    protected function lastMonthsTrend(int $months): array
    {
        $start = now()->startOfMonth()->subMonthsNoOverflow($months - 1);

        $counts = Meeting::where('start_at', '>=', $start)
            ->pluck('start_at')
            ->countBy(fn ($date) => $date->format('Y-m'));

        $trend = [];
        for ($i = 0; $i < $months; $i++) {
            $trend[] = $counts->get($start->copy()->addMonthsNoOverflow($i)->format('Y-m'), 0);
        }

        return $trend;
    }

    protected function readableSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        $size = (float) $bytes;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2) . ' ' . $units[$i];
    }
}
