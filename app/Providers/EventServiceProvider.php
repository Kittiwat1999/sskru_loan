<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;

use App\Listeners\AuthLogListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            AuthLogListener::class,
        ],
        Failed::class => [
            AuthLogListener::class,
        ],
        Logout::class => [
            AuthLogListener::class,
        ],
        Lockout::class => [
            AuthLogListener::class,
        ],
        PasswordReset::class => [
            AuthLogListener::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
    }
}