<?php

namespace App\Filament\Octagon\Resources;

use App\Filament\Octagon\Concerns\ReadOnlyResource;
use App\Filament\Octagon\Resources\CategoryResource\Pages;
use App\Filament\Octagon\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use App\Models\Meeting;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends ReadOnlyResource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    protected static ?string $navigationLabel = 'الفئات';

    protected static ?string $modelLabel = 'فئة';

    protected static ?string $pluralModelLabel = 'الفئات';

    protected static ?string $navigationGroup = 'البيانات الأساسية';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('users')
            ->addSelect([
                'meetings_count' => Meeting::query()
                    ->selectRaw('count(*)')
                    ->join('users', 'users.id', '=', 'meetings.created_by')
                    ->whereColumn('users.category_id', 'categories.id'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('بيانات الفئة')
                    ->icon('heroicon-o-rectangle-group')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')->label('الاسم')->weight('bold')->size('lg'),
                        Infolists\Components\TextEntry::make('slug')->label('المعرف')->badge()->color('gray'),
                        Infolists\Components\TextEntry::make('users_count')->label('عدد الأعضاء')->badge()->color('primary'),
                        Infolists\Components\TextEntry::make('meetings_count')->label('اجتماعات نظمها أعضاؤها')->badge()->color('info'),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('الفئة')->searchable()->sortable()->weight('bold'),
                Tables\Columns\TextColumn::make('slug')->label('المعرف')->badge()->color('gray')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('users_count')->label('الأعضاء')->alignCenter()->sortable()->badge()->color('primary'),
                Tables\Columns\TextColumn::make('meetings_count')->label('اجتماعات نظمها أعضاؤها')->alignCenter()->sortable()->badge()->color('info'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('عرض'),
            ])
            ->bulkActions([])
            ->striped();
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'view' => Pages\ViewCategory::route('/{record}'),
        ];
    }
}
