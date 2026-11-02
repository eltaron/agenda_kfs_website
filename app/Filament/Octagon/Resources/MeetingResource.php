<?php

namespace App\Filament\Octagon\Resources;

use App\Filament\Octagon\Concerns\MeetingStatus;
use App\Filament\Octagon\Concerns\ReadOnlyResource;
use App\Filament\Octagon\Resources\MeetingResource\Pages;
use App\Filament\Octagon\Resources\MeetingResource\RelationManagers;
use App\Models\Category;
use App\Models\Meeting;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MeetingResource extends ReadOnlyResource
{
    protected static ?string $model = Meeting::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'الاجتماعات والأرشيف';

    protected static ?string $modelLabel = 'اجتماع';

    protected static ?string $pluralModelLabel = 'الاجتماعات';

    protected static ?string $navigationGroup = 'الاجتماعات';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'room.name'];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['room', 'creator.category'])
            ->withCount([
                'participants',
                'attachments',
                'participants as attending_count' => fn (Builder $q) => $q->where('meeting_user.status', 'attending'),
                'participants as declined_count' => fn (Builder $q) => $q->where('meeting_user.status', 'declined'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('تفاصيل الاجتماع')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')->label('الموضوع')->weight('bold')->size('lg')->columnSpan(2),
                        Infolists\Components\TextEntry::make('status')
                            ->label('الحالة')
                            ->state(fn (Meeting $record) => MeetingStatus::of($record))
                            ->formatStateUsing(fn (string $state) => MeetingStatus::labels()[$state])
                            ->color(fn (string $state) => MeetingStatus::colors()[$state])
                            ->badge(),
                        Infolists\Components\TextEntry::make('room.name')->label('القاعة')->badge()->color('success')->placeholder('-'),
                        Infolists\Components\TextEntry::make('room.location')->label('المكان')->placeholder('-'),
                        Infolists\Components\TextEntry::make('creator.name')->label('المنظم')->placeholder('-'),
                        Infolists\Components\TextEntry::make('start_at')->label('وقت البدء')->dateTime('Y-m-d h:i A')->color('warning'),
                        Infolists\Components\TextEntry::make('end_at')->label('وقت الانتهاء')->dateTime('Y-m-d h:i A')->color('warning'),
                        Infolists\Components\TextEntry::make('duration')
                            ->label('المدة')
                            ->state(fn (Meeting $record) => $record->start_at && $record->end_at
                                ? $record->start_at->diffInMinutes($record->end_at) . ' دقيقة'
                                : '-'),
                    ])->columns(3),

                Infolists\Components\Section::make('إحصائيات الاجتماع')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Infolists\Components\TextEntry::make('participants_count')->label('عدد المدعوين')->badge()->color('primary'),
                        Infolists\Components\TextEntry::make('attending_count')->label('مؤكد الحضور')->badge()->color('success'),
                        Infolists\Components\TextEntry::make('declined_count')->label('معتذر')->badge()->color('danger'),
                        Infolists\Components\TextEntry::make('attachments_count')->label('المرفقات')->badge()->color('gray'),
                    ])->columns(4),

                Infolists\Components\Section::make('الأجندة والتفاصيل')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->schema([
                        Infolists\Components\TextEntry::make('description')->label('التفاصيل')->html()->placeholder('لا يوجد')->columnSpanFull(),
                        Infolists\Components\TextEntry::make('agenda')->label('الأجندة')->html()->placeholder('لا يوجد')->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('title')->label('موضوع الاجتماع')->searchable()->sortable()->weight('bold')->color('primary')->wrap(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->state(fn (Meeting $record) => MeetingStatus::of($record))
                    ->formatStateUsing(fn (string $state) => MeetingStatus::labels()[$state])
                    ->color(fn (string $state) => MeetingStatus::colors()[$state])
                    ->badge(),
                Tables\Columns\TextColumn::make('start_at')->label('البدء')->dateTime('Y-m-d h:i A')->color('warning')->sortable(),
                Tables\Columns\TextColumn::make('end_at')->label('الانتهاء')->dateTime('Y-m-d h:i A')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('room.name')->label('القاعة')->badge()->color('success')->searchable()->placeholder('-'),
                Tables\Columns\TextColumn::make('creator.name')->label('المنظم')->searchable()->color('gray')->placeholder('-'),
                Tables\Columns\TextColumn::make('creator.category.name')->label('فئة المنظم')->toggleable(isToggledHiddenByDefault: true)->placeholder('-'),
                Tables\Columns\TextColumn::make('participants_count')->label('المدعوين')->alignCenter()->sortable(),
                Tables\Columns\TextColumn::make('attending_count')->label('مؤكد')->alignCenter()->color('success')->sortable(),
                Tables\Columns\TextColumn::make('declined_count')->label('معتذر')->alignCenter()->color('danger')->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('attachments_count')->label('المرفقات')->alignCenter()->sortable()->icon('heroicon-m-paper-clip'),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->dateTime('Y-m-d')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('الحالة')
                    ->options(MeetingStatus::labels())
                    ->query(fn (Builder $query, array $data) => MeetingStatus::scope($query, $data['value'] ?? null)),
                Tables\Filters\SelectFilter::make('room_id')
                    ->label('القاعة')
                    ->relationship('room', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('created_by')
                    ->label('المنظم')
                    ->relationship('creator', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('category')
                    ->label('فئة المنظم')
                    ->options(fn () => Category::pluck('name', 'id')->all())
                    ->query(fn (Builder $query, array $data) => filled($data['value'] ?? null)
                        ? $query->whereHas('creator', fn (Builder $q) => $q->where('category_id', $data['value']))
                        : $query),
                Tables\Filters\Filter::make('date_range')
                    ->label('الفترة')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('من تاريخ'),
                        Forms\Components\DatePicker::make('until')->label('إلى تاريخ'),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('start_at', '>=', $date))
                        ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('start_at', '<=', $date)))
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['from'] ?? null) {
                            $indicators[] = 'من: ' . $data['from'];
                        }
                        if ($data['until'] ?? null) {
                            $indicators[] = 'إلى: ' . $data['until'];
                        }

                        return $indicators;
                    }),
                Tables\Filters\TernaryFilter::make('has_attachments')
                    ->label('المرفقات')
                    ->placeholder('الكل')
                    ->trueLabel('بها مرفقات')
                    ->falseLabel('بدون مرفقات')
                    ->queries(
                        true: fn (Builder $q) => $q->has('attachments'),
                        false: fn (Builder $q) => $q->doesntHave('attachments'),
                    ),
            ])
            ->filtersFormColumns(3)
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
            ])
            ->bulkActions([])
            ->defaultSort('start_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ParticipantsRelationManager::class,
            RelationManagers\AttachmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'view' => Pages\ViewMeeting::route('/{record}'),
        ];
    }
}
