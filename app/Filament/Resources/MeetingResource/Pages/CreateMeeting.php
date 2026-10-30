<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class CreateMeeting extends CreateRecord
{
    protected static string $resource = MeetingResource::class;

    // يتم تشغيل هذا الكود بعد حفظ الاجتماع والمشاركين بنجاح
    protected function afterCreate(): void
    {
        $meeting = $this->record; // الاجتماع الذي تم إنشاؤه
        $participants = $meeting->participants; // الموظفين المدعوين
        $creator = auth()->user()->name; // اسم الشخص اللي عمل الاجتماع

        foreach ($participants as $user) {
            Notification::make()
                ->title('دعوة لاجتماع جديد')
                ->icon('heroicon-o-calendar-days')
                ->body("تمت دعوتك لحضور اجتماع: {$meeting->title} بواسطة {$creator}")
                ->success()
                ->actions([
                    Action::make('view')
                        ->label('عرض التفاصيل')
                        ->url(MeetingResource::getUrl('edit', ['record' => $meeting])),
                ])
                ->sendToDatabase($user); // إرسال الإشعار لقاعدة البيانات للمستخدم المحدد
        }
    }
}
