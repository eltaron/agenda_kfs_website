<?php

namespace App\Filament\Octagon\Resources\MeetingResource\RelationManagers;

use App\Filament\Octagon\Concerns\MeetingStatus;
use App\Filament\Octagon\Concerns\ReadOnlyRelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ParticipantsRelationManager extends ReadOnlyRelationManager
{
    protected static string $relationship = 'participants';

    protected static ?string $title = 'المدعوين';

    protected static ?string $icon = 'heroicon-o-users';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modifyQueryUsing(fn ($query) => $query->with('category'))
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('category.name')->label('الفئة')->badge()->color('gray')->placeholder('-'),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف')->searchable()->placeholder('-'),
                Tables\Columns\TextColumn::make('email')->label('البريد')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->label('حالة الدعوة')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => MeetingStatus::participantStatusLabels()[$state] ?? $state)
                    ->color(fn (?string $state) => MeetingStatus::participantStatusColors()[$state] ?? 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة الدعوة')
                    ->options(MeetingStatus::participantStatusLabels())
                    ->query(fn ($query, array $data) => filled($data['value'] ?? null)
                        ? $query->where('meeting_user.status', $data['value'])
                        : $query),
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
