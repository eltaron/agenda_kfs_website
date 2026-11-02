<?php

namespace App\Filament\Octagon\Resources\CategoryResource\RelationManagers;

use App\Filament\Octagon\Concerns\ReadOnlyRelationManager;
use App\Filament\Octagon\Resources\UserResource;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;

class UsersRelationManager extends ReadOnlyRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $title = 'أعضاء الفئة';

    protected static ?string $icon = 'heroicon-o-users';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modifyQueryUsing(fn ($query) => $query->withCount(['createdMeetings', 'attendingMeetings']))
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable()->weight('bold')->wrap(),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف')->searchable()->placeholder('-'),
                Tables\Columns\TextColumn::make('created_meetings_count')->label('نظّم')->alignCenter()->sortable(),
                Tables\Columns\TextColumn::make('attending_meetings_count')->label('مدعو إلى')->alignCenter()->sortable(),
            ])
            ->recordUrl(fn (User $record) => UserResource::getUrl('view', ['record' => $record]))
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
