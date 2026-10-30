<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\MeetingResource;
use App\Models\Meeting;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TodayMeetings extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full'; // يأخذ عرض الصفحة كاملاً
    protected static ?string $heading = '📅 اجتماعات اليوم';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Meeting::query()->whereDate('start_at', today())->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان الاجتماع')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('start_at')
                    ->label('وقت البدء')
                    ->dateTime('h:i A')
                    ->color('warning'),
                Tables\Columns\TextColumn::make('room.name')
                    ->label('القاعة')
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('المنظم'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('فتح')
                    ->url(fn(Meeting $record): string => MeetingResource::getUrl('edit', ['record' => $record])) // غيرنا view إلى edit
                    ->icon('heroicon-m-pencil-square'), // غيرنا الأيقونة لتناسب التعديل
            ]);
    }
}
