<?php

namespace App\Filament\Octagon\Resources\RoomResource\RelationManagers;

use App\Filament\Octagon\Concerns\MeetingStatus;
use App\Filament\Octagon\Concerns\ReadOnlyRelationManager;
use App\Filament\Octagon\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Tables;
use Filament\Tables\Table;

class MeetingsRelationManager extends ReadOnlyRelationManager
{
    protected static string $relationship = 'meetings';

    protected static ?string $title = 'اجتماعات القاعة';

    protected static ?string $icon = 'heroicon-o-calendar-days';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->modifyQueryUsing(fn ($query) => $query->with('creator')->withCount('participants'))
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('الموضوع')->searchable()->weight('bold')->wrap(),
                Tables\Columns\TextColumn::make('start_at')->label('الموعد')->dateTime('Y-m-d h:i A')->sortable()->color('warning'),
                Tables\Columns\TextColumn::make('creator.name')->label('المنظم')->placeholder('-'),
                Tables\Columns\TextColumn::make('participants_count')->label('المدعوين')->alignCenter(),
                Tables\Columns\TextColumn::make('meeting_state')
                    ->label('الحالة')
                    ->state(fn (Meeting $record) => MeetingStatus::of($record))
                    ->formatStateUsing(fn (string $state) => MeetingStatus::labels()[$state])
                    ->color(fn (string $state) => MeetingStatus::colors()[$state])
                    ->badge(),
            ])
            ->defaultSort('start_at', 'desc')
            ->recordUrl(fn (Meeting $record) => MeetingResource::getUrl('view', ['record' => $record]))
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
