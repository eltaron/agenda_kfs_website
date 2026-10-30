<?php

namespace App\Filament\Resources\MeetingResource\Pages;

use App\Filament\Resources\MeetingResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditMeeting extends EditRecord
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        $meeting = $this->record;
        $participants = $meeting->participants;

        foreach ($participants as $user) {
            Notification::make()
                ->title('تحديث في موعد اجتماع')
                ->body("تم تحديث بيانات الاجتماع: {$meeting->title}")
                ->info()
                ->sendToDatabase($user);
        }
    }
}
