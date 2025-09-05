<?php

namespace App\Providers;

use Auth;
use Illuminate\Support\ServiceProvider;
use View;

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
        // مشاركة الإشعارات مع جميع الـ views
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('notifications', Auth::user()->notifications()->latest()->take(5)->get());
            } else {
                $view->with('notifications', collect());
            }
        });
    }
}
