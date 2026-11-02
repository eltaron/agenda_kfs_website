<?php

namespace App\Filament\Octagon\Resources\MeetingResource\Pages;

use App\Filament\Octagon\Concerns\MeetingStatus;
use App\Filament\Octagon\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMeetings extends ListRecords
{
    protected static string $resource = MeetingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('الكل')
                ->icon('heroicon-m-queue-list')
                ->badge(Meeting::count()),
            'today' => Tab::make('اليوم')
                ->icon('heroicon-m-calendar')
                ->badge(Meeting::whereDate('start_at', today())->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereDate('start_at', today())),
            MeetingStatus::UPCOMING => Tab::make('القادمة')
                ->icon('heroicon-m-clock')
                ->badge(MeetingStatus::scope(Meeting::query(), MeetingStatus::UPCOMING)->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => MeetingStatus::scope($query, MeetingStatus::UPCOMING)),
            MeetingStatus::ONGOING => Tab::make('الجارية الآن')
                ->icon('heroicon-m-play')
                ->badge(MeetingStatus::scope(Meeting::query(), MeetingStatus::ONGOING)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => MeetingStatus::scope($query, MeetingStatus::ONGOING)),
            MeetingStatus::ARCHIVED => Tab::make('الأرشيف')
                ->icon('heroicon-m-archive-box')
                ->badge(MeetingStatus::scope(Meeting::query(), MeetingStatus::ARCHIVED)->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query) => MeetingStatus::scope($query, MeetingStatus::ARCHIVED)),
        ];
    }
}
