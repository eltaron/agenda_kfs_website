<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers\UsersRelationManager;
use App\Filament\Resources\UserResource;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class CategoryResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'فئات المستخدمين';
    protected static ?string $modelLabel = 'فئة';
    protected static ?string $pluralModelLabel = 'الفئات';
    protected static ?string $navigationGroup = 'إدارة النظام';

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('بيانات الفئة الأساسية')
                    ->description('أدخل اسم الفئة وسيتم توليد الرابط المختصر تلقائياً')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الفئة')
                            ->placeholder('مثال: فئة القيادات')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', str($state)->slug())),

                        Forms\Components\TextInput::make('slug')
                            ->label('الرابط المختصر (Slug)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // اسم الفئة
                Tables\Columns\TextColumn::make('name')
                    ->label('اسم الفئة')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-tag')
                    ->color('primary'),

                // الرمز المختصر
                Tables\Columns\TextColumn::make('slug')
                    ->label('الرمز (Slug)')
                    ->searchable()
                    ->color('gray'),

                // عدد الأعضاء
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('عدد الأعضاء')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),

                // تاريخ الإنشاء
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('من تاريخ'),
                        Forms\Components\DatePicker::make('created_until')->label('إلى تاريخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    })
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    // زر عرض الموظفين
                    Tables\Actions\Action::make('view_members')
                        ->label('عرض الموظفين')
                        ->icon('heroicon-m-users')
                        ->color('info')
                        ->url(fn(Category $record): string => UserResource::getUrl('index', [
                            'tableFilters[category_id][value]' => $record->id,
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
            ->defaultSort('users_count', 'desc') // ترتيب حسب الأكثر عدداً
            ->striped();
    }

    public static function getPermissionPrefixes(): array
    {
        return ['view', 'view_any', 'create', 'update', 'delete', 'delete_any'];
    }

    public static function getRelations(): array
    {
        return [
            UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
