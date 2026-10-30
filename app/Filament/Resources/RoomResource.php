<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class RoomResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Room::class;
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel = 'قاعات الاجتماعات';
    protected static ?string $modelLabel = 'قاعة';
    protected static ?string $pluralModelLabel = 'القاعات';
    protected static ?string $navigationGroup = 'إدارة النظام';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('بيانات القاعة')
                    ->description('أدخل تفاصيل القاعة أو مكان الاجتماع')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم القاعة/الغرفة')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('location')
                            ->label('الموقع/الدور')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('capacity')
                            ->label('السعة الاستيعابية (أفراد)')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('القاعة متاحة للاستخدام حالياً')
                            ->default(true)
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // اسم القاعة
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم القاعة')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-building-office'),

                // الموقع
                Tables\Columns\TextColumn::make('location')
                    ->label('الموقع')
                    ->searchable()
                    ->icon('heroicon-m-map-pin')
                    ->color('gray')
                    ->wrap(),

                // السعة
                Tables\Columns\TextColumn::make('capacity')
                    ->label('السعة')
                    ->suffix(' فرد')
                    ->sortable()
                    ->alignCenter(),

                // عدد الاجتماعات
                Tables\Columns\TextColumn::make('meetings_count')
                    ->counts('meetings')
                    ->label('إجمالي الاجتماعات')
                    ->badge()
                    ->color('warning')
                    ->alignCenter(),

                // الحالة (زر تبديل مباشر)
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('الحالة (متاح)')
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('حالة الإتاحة')
                    ->trueLabel('القاعات المتاحة')
                    ->falseLabel('القاعات المغلقة'),

                Tables\Filters\Filter::make('capacity')
                    ->form([
                        Forms\Components\TextInput::make('min_capacity')
                            ->label('الحد الأدنى للسعة')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['min_capacity'], fn($q, $val) => $q->where('capacity', '>=', $val));
                    })
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // زر عرض اجتماعات القاعة
                    Tables\Actions\Action::make('view_meetings')
                        ->label('جدول القاعة')
                        ->icon('heroicon-m-calendar-days')
                        ->color('warning')
                        ->url(fn(Room $record): string => MeetingResource::getUrl('index', [
                            'tableFilters[room_id][value]' => $record->id,
                        ])),

                    Tables\Actions\EditAction::make()->label('تعديل'),
                    Tables\Actions\DeleteAction::make()->label('حذف'),
                ])
                    ->label('الخيارات')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('gray')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(12)
            ->striped();
    }

    public static function getPermissionPrefixes(): array
    {
        return ['view', 'view_any', 'create', 'update', 'delete', 'delete_any'];
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
