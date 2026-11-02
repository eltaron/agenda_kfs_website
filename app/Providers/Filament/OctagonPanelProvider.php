<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * لوحة Octagon: لوحة متابعة وإحصائيات للقراءة فقط
 * (لا يوجد بها أي إضافة أو تعديل أو حذف).
 */
class OctagonPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('octagon')
            ->path('octagon')
            ->login()
            ->brandName('Octagon')
            ->brandLogo(asset('logo.png'))
            ->brandLogoHeight('3.5rem')
            ->favicon(asset('favicon/favicon.ico'))
            ->colors([
                'primary' => [
                    50 => '#fdf9ec',
                    100 => '#f9f0ce',
                    200 => '#f2df9d',
                    300 => '#ebc963',
                    400 => '#e3b13a',
                    500 => '#d1a13c',
                    600 => '#b57f2e',
                    700 => '#966128',
                    800 => '#7d4f25',
                    900 => '#6a4221',
                    950 => '#3d220f',
                ],
                'gray' => Color::Slate,
            ])
            ->font('Tajawal')
            ->maxContentWidth(MaxWidth::Full)
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'الاجتماعات',
                'البيانات الأساسية',
            ])
            ->discoverResources(in: app_path('Filament/Octagon/Resources'), for: 'App\\Filament\\Octagon\\Resources')
            ->discoverPages(in: app_path('Filament/Octagon/Pages'), for: 'App\\Filament\\Octagon\\Pages')
            ->discoverWidgets(in: app_path('Filament/Octagon/Widgets'), for: 'App\\Filament\\Octagon\\Widgets')
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                'panels::body.start',
                fn () => view('filament.hooks.custom-styles'),
            );
    }
}
