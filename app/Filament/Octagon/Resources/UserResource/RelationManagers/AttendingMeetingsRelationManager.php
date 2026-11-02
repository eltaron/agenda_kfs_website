<?php

namespace App\Filament\Octagon\Resources\UserResource\RelationManagers;

use App\Filament\Octagon\Concerns\MeetingStatus;
use App\Filament\Octagon\Concerns\ReadOnlyRelationManager;
use App\Filament\Octagon\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Tables;
use Filament\Tables\Table;

class AttendingMeetingsRelationManager extends ReadOnlyRelationManager
{
    protected static string $relationship = 'attendingMeetings';

    protected static ?string $title = 'الاجتماعات المدعو إليها';

    protected static ?string $icon = 'heroicon-o-envelope-open';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->modifyQueryUsing(fn ($query) => $query->with('room'))
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('الموضوع')->searchable()->weight('bold')->wrap(),
                Tables\Columns\TextColumn::make('start_at')->label('الموعد')->dateTime('Y-m-d h:i A')->sortable()->color('warning'),
                Tables\Columns\TextColumn::make('room.name')->label('القاعة')->badge()->color('success')->placeholder('-'),
                Tables\Columns\TextColumn::make('meeting_state')
                    ->label('الحالة')
                    ->state(fn (Meeting $record) => MeetingStatus::of($record))
                    ->formatStateUsing(fn (string $state) => MeetingStatus::labels()[$state])
                    ->color(fn (string $state) => MeetingStatus::colors()[$state])
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->label('رده على الدعوة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => MeetingStatus::participantStatusLabels()[$state] ?? $state)
                    ->color(fn (?string $state) => MeetingStatus::participantStatusColors()[$state] ?? 'gray'),
            ])
            ->defaultSort('start_at', 'desc')
            ->recordUrl(fn (Meeting $record) => MeetingResource::getUrl('view', ['record' => $record]))
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
