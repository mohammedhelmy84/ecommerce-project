<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;

class EventServiceProvider extends ServiceProvider
{
    /**
     * خريطة الأحداث إلى المستمعين
     */
    protected $listen = [
        // أحداث Laravel الافتراضية إن وجدت...
        Login::class => [
            \App\Listeners\LoginCartRestorer::class,
        ],
    ];

    /**
     * تسجيل أي أحداث إضافية
     */
    public function boot(): void
    {
        //
    }
}
