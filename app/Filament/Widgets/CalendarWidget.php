<?php

namespace App\Filament\Widgets;

use App\Models\Meeting;
use App\Filament\Resources\MeetingResource;
use Filament\Forms\Form;
use Filament\Widgets\Widget;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 1;
    // داخل كلاس CalendarWidget
    protected int | string | array $columnSpan = 'full';
    // جلب البيانات للتقويم
    public function fetchEvents(array $fetchInfo): array
    {
        $user = auth()->user();

        return Meeting::query()
            ->where('start_at', '>=', $fetchInfo['start'])
            ->where('end_at', '<=', $fetchInfo['end'])
            ->when($user->category?->slug !== 'leaders' && !$user->hasRole('super_admin'), function ($query) use ($user) {
                // لغير القيادات: يرى ما أنشأه أو ما دُعي إليه فقط
                $query->where(function ($q) use ($user) {
                    $q->where('created_by', $user->id)
                        ->orWhereHas('participants', fn($p) => $p->where('user_id', $user->id));
                });
            })
            ->get()
            ->map(function (Meeting $meeting) {
                return [
                    'id'    => $meeting->id,
                    'title' => "📌 {$meeting->title} - {$meeting->room?->name}",
                    'start' => $meeting->start_at,
                    'end'   => $meeting->end_at,
                    'url'   => MeetingResource::getUrl('view', ['record' => $meeting]),
                    'color' => '#d1a13c', // اللون الذهبي الخاص بكفر الشيخ
                ];
            })
            ->toArray();
    }

    // إعدادات شكل التقويم
    public function config(): array
    {
        return [
            'initialView' => 'timeGridDay', // عرض اليوم بشكل افتراضي (Daily Appointments)
            'headerToolbar' => [
                'left'   => 'prev,next today',
                'center' => 'title',
                'right'  => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'locale' => 'ar', // اللغة العربية
            'firstDay' => 6,  // يبدأ بالأسبوع من يوم السبت
        ];
    }

    // ماذا يحدث عند الضغط على موعد؟
    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('إضافة اجتماع سريع')
                ->mountUsing(fn(Form $form) => $form->fill([
                    'created_by' => auth()->id(),
                ])),
        ];
    }
}
