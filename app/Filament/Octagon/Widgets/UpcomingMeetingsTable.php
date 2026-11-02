<?php

namespace App\Filament\Octagon\Widgets;

use App\Filament\Octagon\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingMeetingsTable extends BaseWidget
{
    protected static ?string $heading = 'الاجتماعات القادمة';

    protected static ?int $sort = 8;

    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Meeting::query()
                    ->with(['room', 'creator'])
                    ->withCount('participants')
                    ->where('end_at', '>=', now())
                    ->orderBy('start_at')
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('الموضوع')->weight('bold')->limit(40)->wrap(),
                Tables\Columns\TextColumn::make('start_at')->label('الموعد')->dateTime('Y-m-d h:i A')->color('warning'),
                Tables\Columns\TextColumn::make('room.name')->label('القاعة')->badge()->color('success')->placeholder('-'),
                Tables\Columns\TextColumn::make('participants_count')->label('المدعوين')->alignCenter(),
            ])
            ->recordUrl(fn (Meeting $record) => MeetingResource::getUrl('view', ['record' => $record]))
            ->emptyStateHeading('لا توجد اجتماعات قادمة')
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
