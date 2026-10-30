<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MeetingResource\Pages;
use App\Filament\Resources\MeetingResource\RelationManagers\ParticipantsRelationManager;
use App\Models\Meeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Tabs;
use Filament\Notifications\Notification;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;

class MeetingResource extends Resource
{
    protected static ?string $model = Meeting::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'إدارة الاجتماعات';
    protected static ?string $modelLabel = 'اجتماع';
    protected static ?string $pluralModelLabel = 'الاجتماعات';
    protected static ?string $navigationGroup = 'إدارة الاجتماعات';
    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'room.name'];
    }

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        if ($user->hasRole('super_admin') || ($user->category && $user->category->slug === 'leaders')) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($user) {
            $q->where('created_by', $user->id)
                ->orWhereHas('participants', fn($p) => $p->where('user_id', $user->id));
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Meeting Details')
                    ->tabs([
                        Tabs\Tab::make('بيانات الاجتماع')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('عنوان الاجتماع')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('room_id')
                                    ->label('القاعة / المكان')
                                    ->relationship('room', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                                Forms\Components\DateTimePicker::make('start_at')
                                    ->label('وقت البدء')
                                    ->required(),
                                Forms\Components\DateTimePicker::make('end_at')
                                    ->label('وقت الانتهاء')
                                    ->required(),
                                Forms\Components\RichEditor::make('description')
                                    ->label('أجندة الاجتماع / تفاصيل')
                                    ->columnSpanFull(),
                                Forms\Components\Hidden::make('created_by')
                                    ->default(Auth::id()),
                            ])->columns(2),

                        Tabs\Tab::make('المشاركين')
                            ->icon('heroicon-o-users')
                            ->schema([
                                Forms\Components\Select::make('participants')
                                    ->label('دعوة أعضاء للاجتماع')
                                    ->multiple()
                                    ->relationship('participants', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->columnSpanFull(),
                            ]),

                        Tabs\Tab::make('المرفقات')
                            ->icon('heroicon-o-paper-clip')
                            ->schema([
                                Forms\Components\Repeater::make('attachments')
                                    ->relationship('attachments')
                                    ->label('ملفات الاجتماع')
                                    ->schema([
                                        Forms\Components\FileUpload::make('file_path')
                                            ->label('ارفع الملف')
                                            ->directory('meetings/attachments')
                                            ->required()
                                            ->preserveFilenames()
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                if ($state) {
                                                    $set('file_name', $state->getClientOriginalName());
                                                    $set('file_type', $state->getClientMimeType());
                                                    $set('file_size', $state->getSize());
                                                }
                                            }),
                                        Forms\Components\Hidden::make('file_name')
                                    ])
                                    ->grid(2)
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    // تصميم صفحة العرض (View Page Design)
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('تفاصيل الاجتماع')
                    ->schema([
                        Infolists\Components\TextEntry::make('title')->label('الموضوع')->weight('bold')->size('lg'),
                        Infolists\Components\TextEntry::make('room.name')->label('القاعة')->badge()->color('success'),
                        Infolists\Components\TextEntry::make('start_at')->label('التاريخ والوقت')->dateTime('Y-m-d h:i A')->color('warning'),
                        Infolists\Components\TextEntry::make('description')->label('الأجندة')->html()->columnSpanFull(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('موضوع الاجتماع')->searchable()->weight('bold')->color('primary'),
                Tables\Columns\TextColumn::make('start_at')->label('الموعد')->dateTime('Y-m-d h:i A')->color('warning')->sortable(),
                Tables\Columns\TextColumn::make('room.name')->label('القاعة')->badge()->color('success'),
                Tables\Columns\TextColumn::make('creator.name')->label('بواسطة')->color('gray'),
                Tables\Columns\TextColumn::make('participants_count')->counts('participants')->label('المدعوين')->alignCenter(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->label('عرض وتفاصيل'),
                    Tables\Actions\EditAction::make()->label('تعديل'),

                    // --- زر إرسال التذكير مع التحويل ---
                    Tables\Actions\Action::make('send_reminder')
                        ->label('تذكير وتحويل للقائمة')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (Meeting $record) {
                            // 1. إرسال الإشعار
                            foreach ($record->participants as $user) {
                                Notification::make()
                                    ->title('تذكير بموعد اجتماع')
                                    ->body("الاجتماع: {$record->title} سيبدأ في {$record->start_at->format('h:i A')}")
                                    ->warning()
                                    ->sendToDatabase($user);
                            }

                            Notification::make()->title('تم إرسال التذكير')->success()->send();

                            // 2. التحويل لصفحة العرض (التي تحتوي على قائمة الأسماء والواتساب)
                            return redirect(MeetingResource::getUrl('view', ['record' => $record]));
                        }),
                    // -------------------------------------
                ])
                    ->label('خيارات')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->button()
                    ->color('gray'),
            ])
            ->defaultSort('start_at', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            // تفعيل الـ RelationManager للمشاركين
            ParticipantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeetings::route('/'),
            'create' => Pages\CreateMeeting::route('/create'),
            // تأكد من وجود صفحة view هنا
            'view' => Pages\ViewMeeting::route('/{record}'),
            'edit' => Pages\EditMeeting::route('/{record}/edit'),
        ];
    }
}
