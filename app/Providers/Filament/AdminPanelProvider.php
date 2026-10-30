<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Enums\MaxWidth;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            // 1. الهوية البصرية (اسم النظام والشعار)
            ->brandLogo(asset('logo.png')) // تأكد من وضع الشعار في public/images/logo.png
            ->brandName('AgendaPro')
            ->brandLogoHeight('3.5rem')
            ->favicon(asset('favicon/favicon.ico')) // تأكد من وضع الشعار في public/images/logo.png

            // 2. الألوان المخصصة (درجات الذهبي والأسود لتناسب الصورة)
            ->colors([
                'primary' => [
                    50 => '#fdf9ec',
                    100 => '#f9f0ce',
                    200 => '#f2df9d',
                    300 => '#ebc963',
                    400 => '#e3b13a',
                    500 => '#d1a13c', // اللون الذهبي الأساسي مطابق للزر في الصورة
                    600 => '#b57f2e',
                    700 => '#966128',
                    800 => '#7d4f25',
                    900 => '#6a4221',
                    950 => '#3d220f',
                ],
                'gray' => Color::Slate,
            ])

            // 3. الخط العربي الاحترافي
            ->font('Tajawal')

            // 4. تفعيل الإشعارات (Database Notifications)
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')

            // 5. عرض الواجهة بالكامل (Full Width) لراحة العين
            ->maxContentWidth(MaxWidth::Full)

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\ManageSettings::class, // صفحة الإعدادات التي أنشأناها
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\FilamentInfoWidget::class, // تم إخفاؤه ليكون السيستم مخصص لك فقط
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentFullCalendarPlugin::make()
                    ->selectable() // إمكانية اختيار وقت بالماوس
                    ->editable(),
                FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            // تفعيل الـ RTL تلقائياً للعربية
            ->renderHook(
                'panels::body.start',
                fn() => view('filament.hooks.custom-styles'),
            );
    }
}
