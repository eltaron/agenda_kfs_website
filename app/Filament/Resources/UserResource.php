<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'الموظفين / المستخدمين';
    protected static ?string $modelLabel = 'موظف';
    protected static ?string $pluralModelLabel = 'الموظفين';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('البيانات الشخصية')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم بالكامل')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف / الواتساب')
                            ->tel()
                            ->placeholder('01xxxxxxxxx')
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->label('الفئة الوظيفية')
                            ->relationship('category', 'name')
                            ->required()
                            ->preload()
                            ->searchable(),

                        // --- إضافة حقل الأدوار هنا ---
                        Forms\Components\Select::make('roles')
                            ->label('الصلاحيات / الأدوار')
                            ->relationship('roles', 'name') // العلاقة مع جدول الأدوار
                            ->multiple() // السماح باختيار أكثر من دور
                            ->preload()
                            ->searchable(),
                        // ---------------------------

                        Forms\Components\TextInput::make('password')
                            ->label('كلمة المرور')
                            ->password()
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // عمود الاسم
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم بالكامل')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // عمود الفئة كـ Badge
                Tables\Columns\TextColumn::make('category.name')
                    ->label('الفئة الوظيفية')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                // --- إضافة عمود الأدوار ---
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('الصلاحيات')
                    ->badge()
                    ->color('warning')
                    ->separator(','), // إذا كان لديه أكثر من دور يفصل بينهم بفاصلة
                // ------------------------
                // عمود الهاتف
                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->icon('heroicon-m-phone')
                    ->color('success')
                    ->searchable(),
                // عمود البريد الإلكتروني
                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->icon('heroicon-m-envelope')
                    ->copyable()
                    ->searchable(),



                // عمود تاريخ الإضافة
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('فلترة حسب الفئة')
                    ->relationship('category', 'name'),

                // فلتر إضافي حسب الدور (اختياري)
                Tables\Filters\SelectFilter::make('roles')
                    ->label('فلترة حسب الصلاحية')
                    ->relationship('roles', 'name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('print_credentials')
                        ->label('طباعة بيانات الدخول')
                        ->icon('heroicon-o-printer') // أيقونة الطابعة
                        ->color('info') // لون أزرق
                        ->url(fn(User $record) => route('users.print', $record)) // التوجيه للمسار الذي أنشأناه
                        ->openUrlInNewTab(),
                    Tables\Actions\Action::make('whatsapp')
                        ->label('مراسلة واتساب')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->color('success')
                        ->url(function (User $record) {
                            if (!$record->phone) return null;
                            $phone = preg_replace('/[^0-9]/', '', $record->phone);
                            if (str_starts_with($phone, '01')) {
                                $phone = '2' . $phone;
                            }
                            return "https://wa.me/{$phone}?text=" . urlencode("السلام عليكم أ/ {$record->name}");
                        })
                        ->openUrlInNewTab(),

                    Tables\Actions\Action::make('view_meetings')
                        ->label('عرض المواعيد')
                        ->icon('heroicon-m-calendar')
                        ->color('warning')
                        ->url(fn(User $record): string => MeetingResource::getUrl('index', [
                            'tableFilters[user_id][value]' => $record->id,
                        ])),

                    Tables\Actions\EditAction::make()->label('تعديل البيانات'),
                    Tables\Actions\DeleteAction::make()->label('حذف الموظف'),
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
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
