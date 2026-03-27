<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔥 LOG LOGIN
        Event::listen(Login::class, function ($event) {
            activity()
                ->causedBy($event->user)
                ->withProperties([
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('Login');
        });

        // 🔥 LOG LOGOUT
        Event::listen(Logout::class, function ($event) {
            activity()
                ->causedBy($event->user)
                ->log('Logout');
        });
    }
}