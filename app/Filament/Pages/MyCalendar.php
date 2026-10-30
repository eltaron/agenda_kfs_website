<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CalendarWidget;

class MyCalendar extends Page
{
    // الأيقونة في القائمة الجانبية
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    // اسم الصفحة في القائمة
    protected static ?string $navigationLabel = 'أجندة المواعيد';

    // عنوان الصفحة الداخلي
    protected static ?string $title = 'التقويم اليومي للمواعيد';

    // ترتيب الظهور في القائمة
    protected static ?int $navigationSort = 1;

    // مسار ملف الـ Blade
    protected static string $view = 'filament.pages.my-calendar';
    protected static ?string $navigationGroup = 'إدارة الاجتماعات';

    /**
     * ربط التقويم كـ Widget يظهر في أعلى الصفحة
     */
    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }

    /**
     * جعل الصفحة تأخذ كامل عرض الشاشة لراحة العين عند عرض التقويم
     */
    public function getMaxContentWidth(): \Filament\Support\Enums\MaxWidth
    {
        return \Filament\Support\Enums\MaxWidth::Full;
    }
}
