<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
        Event::listen(BuildingMenu::class, function ($event) {

            // Check if user is impersonating
            if (session()->has('original_user_id')) {
                $event->menu->add([
                    'text' => 'Back to Super Admin',
                    'route' => 'switchBack',
                    'icon' => 'fas fa-user-shield',
                    'method' => 'post',
                ]);
            } else {
                $event->menu->add([
                    'text' => 'Logout',
                    'route' => 'logout',
                    'icon' => 'fas fa-sign-out-alt',
                    'method' => 'post',
                ]);
            }
        });
    }
}
