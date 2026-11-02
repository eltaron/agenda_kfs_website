<?php

namespace App\Filament\Octagon\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopOrganizersTable extends BaseWidget
{
    protected static ?string $heading = 'الأكثر تنظيماً وحضوراً للاجتماعات';

    protected static ?int $sort = 7;

    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                User::query()
                    ->with('category')
                    ->withCount(['createdMeetings', 'attendingMeetings'])
                    ->orderByDesc('created_meetings_count')
                    ->orderByDesc('attending_meetings_count')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->weight('bold')->wrap(),
                Tables\Columns\TextColumn::make('category.name')->label('الفئة')->badge()->color('gray')->placeholder('-'),
                Tables\Columns\TextColumn::make('created_meetings_count')->label('نظّم')->alignCenter()->badge()->color('primary'),
                Tables\Columns\TextColumn::make('attending_meetings_count')->label('مدعو إلى')->alignCenter()->badge()->color('info'),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
