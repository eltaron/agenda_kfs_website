<?php

namespace App\Filament\Octagon\Resources;

use App\Filament\Octagon\Concerns\ReadOnlyResource;
use App\Filament\Octagon\Resources\RoomResource\Pages;
use App\Filament\Octagon\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoomResource extends ReadOnlyResource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'القاعات';

    protected static ?string $modelLabel = 'قاعة';

    protected static ?string $pluralModelLabel = 'القاعات';

    protected static ?string $navigationGroup = 'البيانات الأساسية';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount([
                'meetings',
                'meetings as archived_meetings_count' => fn (Builder $q) => $q->where('end_at', '<', now()),
                'meetings as upcoming_meetings_count' => fn (Builder $q) => $q->where('start_at', '>', now()),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('بيانات القاعة')
                    ->icon('heroicon-o-home-modern')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')->label('الاسم')->weight('bold')->size('lg'),
                        Infolists\Components\TextEntry::make('location')->label('المكان')->placeholder('-'),
                        Infolists\Components\TextEntry::make('capacity')->label('السعة')->suffix(' فرد')->placeholder('-'),
                        Infolists\Components\IconEntry::make('is_active')->label('مفعلة')->boolean(),
                    ])->columns(4),
                Infolists\Components\Section::make('إحصائيات')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Infolists\Components\TextEntry::make('meetings_count')->label('إجمالي الاجتماعات')->badge()->color('primary'),
                        Infolists\Components\TextEntry::make('archived_meetings_count')->label('مؤرشفة')->badge()->color('gray'),
                        Infolists\Components\TextEntry::make('upcoming_meetings_count')->label('قادمة')->badge()->color('info'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('القاعة')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('location')->label('المكان')->searchable()->placeholder('-'),
                Tables\Columns\TextColumn::make('capacity')->label('السعة')->alignCenter()->sortable()->placeholder('-'),
                Tables\Columns\IconColumn::make('is_active')->label('مفعلة')->boolean()->alignCenter(),
                Tables\Columns\TextColumn::make('meetings_count')->label('الاجتماعات')->alignCenter()->sortable()->badge()->color('primary'),
                Tables\Columns\TextColumn::make('archived_meetings_count')->label('مؤرشفة')->alignCenter()->sortable(),
                Tables\Columns\TextColumn::make('upcoming_meetings_count')->label('قادمة')->alignCenter()->sortable()->color('info'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('الحالة')
                    ->placeholder('الكل')->trueLabel('مفعلة')->falseLabel('غير مفعلة'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
            ])
            ->bulkActions([])
            ->defaultSort('meetings_count', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MeetingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'view' => Pages\ViewRoom::route('/{record}'),
        ];
    }
}
