<?php

namespace App\Listeners;

use App\Models\AuthLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;

class AuthLogListener
{
    public function handle(object $event): void
    {
        if ($event instanceof Login) {
            AuthLog::record(
                event: 'login_success',
                status: true,
                userId: $event->user->getAuthIdentifier(),
                emailOrUsername: $event->user->email ?? $event->user->username ?? null
            );
        }

        elseif ($event instanceof Failed) {
            $username = request('email') ?? request('username') ?? null;
            
            AuthLog::record(
                event: 'login_failed',
                status: false,
                userId: $event->user?->getAuthIdentifier(),
                emailOrUsername: $username,
                failureReason: $event->user ? 'Invalid password' : 'User not found'
            );
        }

        elseif ($event instanceof Logout) {
            if ($event->user) {
                AuthLog::record(
                    event: 'logout',
                    status: true,
                    userId: $event->user->getAuthIdentifier(),
                    emailOrUsername: $event->user->email ?? $event->user->username ?? null
                );
            }
        }

        elseif ($event instanceof Lockout) {
            $username = request('email') ?? request('username') ?? null;

            AuthLog::record(
                event: 'lockout',
                status: false,
                emailOrUsername: $username,
                failureReason: 'Too many login attempts'
            );
        }

        elseif ($event instanceof PasswordReset) {
            AuthLog::record(
                event: 'password_reset_completed',
                status: true,
                userId: $event->user->getAuthIdentifier(),
                emailOrUsername: $event->user->email ?? null
            );
        }
    }
}