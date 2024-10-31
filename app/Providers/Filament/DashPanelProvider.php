<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Support\Facades\FilamentColor;

class DashPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('dash')
            ->path('dash')
            ->login()
            ->font('Montserrat')
            ->colors([
                'primary' => '#394867', 
                'danger' => Color::Rose,
                'gray' => [ //rojo '255,82,40'
                    50 => '#F1F6F9', // CLA fondo
                    100 => '110, 217, 227', // CLA fondo al seleccionar crud
                    200 => '255, 255, 255', //OSC txt como Documetation & Github
                    300 => '103, 232, 249', // ?
                    400 => '#0C7B93', //OSC txt de titulos, asi tipo h2 como ser admin, v3.0.0.0 y titulos de los stats
                    500 => '#0C7B93', //OSC color de los logos / icons
                    600 => '8, 145, 178', // ?
                    700 => '#607274', //CLA txt de titulos, asi tipo h2 como ser admin, v3.0.0.0 y titulos de los stats
                    800 => '21, 94, 117', // ?
                    900 => '#222831', //OSC color de los campitos flotantes, osea como los divs dentro de alg
                    950 => '#212A3E', //OSC fondo
                ],

                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
      
                //'primary' => Color::hex('#a99f49'),
            
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
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
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    
            )
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
            ]);
    }
}
