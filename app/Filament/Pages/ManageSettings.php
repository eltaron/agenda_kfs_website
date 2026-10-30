<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;

class ManageSettings extends SettingsPage
{
    // أيقونة الصفحة في القائمة الجانبية
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    // عنوان الصفحة في القائمة
    protected static ?string $navigationLabel = 'إعدادات المنظومة';

    // العنوان الظاهر داخل الصفحة
    protected static ?string $title = 'الإعدادات العامة للمنظومة';

    // المجموعة التي تنتمي إليها الصفحة في القائمة الجانبية
    protected static ?string $navigationGroup = 'إدارة النظام';

    // ربط الصفحة بكلاس الإعدادات الذي أنشأناه سابقاً
    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs([
                        // التبويب الأول: هوية المنظومة
                        Tabs\Tab::make('هوية المنظومة')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Section::make('البيانات الأساسية')
                                    ->description('هذه البيانات تظهر في أعلى لوحة التحكم وفي التقارير')
                                    ->schema([
                                        TextInput::make('site_name')
                                            ->label('اسم المنظومة')
                                            ->placeholder('مثال: منظومة إدارة الاجتماعات - محافظة كفر الشيخ')
                                            ->required(),

                                        FileUpload::make('site_logo')
                                            ->label('شعار المحافظة / المنظومة')
                                            ->directory('settings')
                                            ->image()
                                            ->imageEditor(),

                                        Toggle::make('system_active')
                                            ->label('حالة المنظومة (متاحة للجميع)')
                                            ->helperText('عند تعطيل هذا الخيار، لن يتمكن غير الإدارة من الدخول')
                                            ->default(true),
                                    ])->columns(2),
                            ]),

                        // التبويب الثاني: إعدادات التواصل والواتساب
                        Tabs\Tab::make('إعدادات المراسلات')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Section::make('التواصل والواتساب')
                                    ->description('تخصيص الرسائل التلقائية التي يتم إرسالها للموظفين')
                                    ->schema([
                                        TextInput::make('contact_phone')
                                            ->label('رقم تواصل الدعم الفني')
                                            ->tel()
                                            ->placeholder('2010xxxxxxxx'),

                                        TextInput::make('address')
                                            ->label('مقر العمل الرئيسي')
                                            ->placeholder('مثال: الديوان العام - محافظة كفر الشيخ'),

                                        Textarea::make('whatsapp_message')
                                            ->label('رسالة الترحيب الافتراضية (واتساب)')
                                            ->helperText('هذه الرسالة ستظهر تلقائياً عند الضغط على زر الواتساب في ملف الموظف')
                                            ->rows(4)
                                            ->columnSpanFull(),
                                    ])->columns(2),
                            ]),
                    ])->columnSpanFull()
            ]);
    }
}
