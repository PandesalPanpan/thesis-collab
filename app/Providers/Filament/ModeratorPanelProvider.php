<?php

namespace App\Providers\Filament;

//use Filament\Http\Middleware\Authenticate;
use App\Http\Middleware\FilamentAuthenticate;
use App\Http\Middleware\RedirectToPanel;
use Filament\Facades\Filament;
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
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ModeratorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('moderator')
            ->path('moderator')
            //->registration() //For Testing Purposes until Final
            ->login()
            ->brandName('ITECH Inventory')
            ->colors([
                'primary' => Color::Green,
            ])
            ->discoverResources(in: app_path('Filament/Moderator/Resources'), for: 'App\\Filament\\Moderator\\Resources')
            ->discoverPages(in: app_path('Filament/Moderator/Pages'), for: 'App\\Filament\\Moderator\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Moderator/Widgets'), for: 'App\\Filament\\Moderator\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
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
                RedirectToPanel::class,
            ])
            ->authMiddleware([
                FilamentAuthenticate::class,
            ]);
    }
}
