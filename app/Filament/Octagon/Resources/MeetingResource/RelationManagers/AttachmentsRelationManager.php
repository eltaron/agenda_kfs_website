<?php

namespace App\Filament\Octagon\Resources\MeetingResource\RelationManagers;

use App\Filament\Octagon\Concerns\ReadOnlyRelationManager;
use App\Models\Attachment;
use Filament\Tables;
use Filament\Tables\Table;

class AttachmentsRelationManager extends ReadOnlyRelationManager
{
    protected static string $relationship = 'attachments';

    protected static ?string $title = 'المرفقات';

    protected static ?string $icon = 'heroicon-o-paper-clip';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('file_name')
            ->columns([
                Tables\Columns\TextColumn::make('file_name')->label('اسم الملف')->searchable()->weight('bold')
                    ->state(fn (Attachment $record) => $record->file_name ?: basename($record->file_path)),
                Tables\Columns\TextColumn::make('file_type')->label('النوع')->badge()->color('gray')->placeholder('-'),
                Tables\Columns\TextColumn::make('file_size')->label('الحجم')
                    ->state(fn (Attachment $record) => $record->file_size ? $record->readable_size : '-'),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الرفع')->dateTime('Y-m-d h:i A'),
            ])
            ->headerActions([])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('فتح / تحميل')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->url(fn (Attachment $record) => $record->url)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([]);
    }
}
