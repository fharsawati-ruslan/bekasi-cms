<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')

            ->login()

            // 🎨 warna utama
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->renderHook(
                'panels::head.end',
                fn () => '
        <style>
            .fi-btn-primary {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }
        </style>
    '
            )

            // 🔥 URUTAN SIDEBAR (FINAL)
            ->navigationGroups([

                            NavigationGroup::make()
                                ->label('Transaksi')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Member')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Karyawan')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Keuangan')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Laporan')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Gudang')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Voucher')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Produk')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Cabang')
                                ->collapsed(),

                            NavigationGroup::make()
                                ->label('Master')
                                ->collapsed(),
                        ])

            // auto load resource
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )

            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )

            ->pages([
                Pages\Dashboard::class,
            ])

            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets'
            )

            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ]);
    }
}
