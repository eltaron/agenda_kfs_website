<?php

namespace App\Filament\Octagon\Resources;

use App\Filament\Octagon\Concerns\ReadOnlyResource;
use App\Filament\Octagon\Resources\UserResource\Pages;
use App\Filament\Octagon\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends ReadOnlyResource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'المستخدمين';

    protected static ?string $modelLabel = 'مستخدم';

    protected static ?string $pluralModelLabel = 'المستخدمين';

    protected static ?string $navigationGroup = 'البيانات الأساسية';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone'];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['category', 'roles'])
            ->withCount([
                'createdMeetings',
                'attendingMeetings',
                'attendingMeetings as attending_confirmed_count' => fn (Builder $q) => $q->where('meeting_user.status', 'attending'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('بيانات المستخدم')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')->label('الاسم')->weight('bold')->size('lg'),
                        Infolists\Components\TextEntry::make('category.name')->label('الفئة')->badge()->color('gray')->placeholder('-'),
                        Infolists\Components\TextEntry::make('roles.name')->label('الأدوار')->badge()->placeholder('-'),
                        Infolists\Components\TextEntry::make('email')->label('البريد الإلكتروني')->copyable(),
                        Infolists\Components\TextEntry::make('phone')->label('الهاتف')->placeholder('-')->copyable(),
                        Infolists\Components\TextEntry::make('created_at')->label('تاريخ التسجيل')->dateTime('Y-m-d'),
                    ])->columns(3),
                Infolists\Components\Section::make('إحصائيات')
                    ->icon('heroicon-o-chart-bar')
                    ->schema([
                        Infolists\Components\TextEntry::make('created_meetings_count')->label('اجتماعات نظّمها')->badge()->color('primary'),
                        Infolists\Components\TextEntry::make('attending_meetings_count')->label('دعوات استلمها')->badge()->color('info'),
                        Infolists\Components\TextEntry::make('attending_confirmed_count')->label('أكد حضورها')->badge()->color('success'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable()->sortable()->weight('bold')->wrap(),
                Tables\Columns\TextColumn::make('category.name')->label('الفئة')->badge()->color('gray')->placeholder('-'),
                Tables\Columns\TextColumn::make('roles.name')->label('الأدوار')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('email')->label('البريد')->searchable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف')->searchable()->placeholder('-'),
                Tables\Columns\TextColumn::make('created_meetings_count')->label('نظّم')->alignCenter()->sortable()->badge()->color('primary'),
                Tables\Columns\TextColumn::make('attending_meetings_count')->label('مدعو إلى')->alignCenter()->sortable()->badge()->color('info'),
                Tables\Columns\TextColumn::make('attending_confirmed_count')->label('أكد الحضور')->alignCenter()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('created_at')->label('تاريخ التسجيل')->dateTime('Y-m-d')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('الفئة')
                    ->relationship('category', 'name')
                    ->preload(),
                Tables\Filters\SelectFilter::make('roles')
                    ->label('الدور')
                    ->relationship('roles', 'name')
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
            ])
            ->bulkActions([])
            ->defaultSort('name')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttendingMeetingsRelationManager::class,
            RelationManagers\CreatedMeetingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
