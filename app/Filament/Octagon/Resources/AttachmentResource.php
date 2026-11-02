<?php

namespace App\Filament\Octagon\Resources;

use App\Filament\Octagon\Concerns\ReadOnlyResource;
use App\Filament\Octagon\Resources\AttachmentResource\Pages;
use App\Models\Attachment;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttachmentResource extends ReadOnlyResource
{
    protected static ?string $model = Attachment::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationLabel = 'أرشيف المرفقات';

    protected static ?string $modelLabel = 'مرفق';

    protected static ?string $pluralModelLabel = 'المرفقات';

    protected static ?string $navigationGroup = 'الاجتماعات';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'file_name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('meeting');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('file_name')->label('اسم الملف')->searchable()->sortable()->weight('bold')->wrap()
                    ->state(fn (Attachment $record) => $record->file_name ?: basename($record->file_path)),
                Tables\Columns\TextColumn::make('meeting.title')->label('الاجتماع')->searchable()->wrap()
                    ->url(fn (Attachment $record) => $record->meeting ? MeetingResource::getUrl('view', ['record' => $record->meeting]) : null)
                    ->color('primary'),
                Tables\Columns\TextColumn::make('meeting.start_at')->label('تاريخ الاجتماع')->dateTime('Y-m-d')->color('warning'),
                Tables\Columns\TextColumn::make('file_type')->label('النوع')->badge()->color('gray')->placeholder('-'),
                Tables\Columns\TextColumn::make('file_size')->label('الحجم')->sortable()
                    ->state(fn (Attachment $record) => $record->file_size ? $record->readable_size : '-'),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ الرفع')->dateTime('Y-m-d h:i A')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('meeting_id')
                    ->label('الاجتماع')
                    ->relationship('meeting', 'title')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('file_type')
                    ->label('نوع الملف')
                    ->options(fn () => Attachment::query()->whereNotNull('file_type')->distinct()->pluck('file_type', 'file_type')->all()),
                Tables\Filters\Filter::make('uploaded_between')
                    ->label('تاريخ الرفع')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('من تاريخ'),
                        Forms\Components\DatePicker::make('until')->label('إلى تاريخ'),
                    ])
                    ->query(fn (Builder $query, array $data) => $query
                        ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '>=', $date))
                        ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '<=', $date))),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('فتح / تحميل')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->url(fn (Attachment $record) => $record->url)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttachments::route('/'),
        ];
    }
}
