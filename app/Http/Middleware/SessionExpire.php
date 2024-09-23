<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SessionExpire
{
    // Define the session lifetime in minutes
    protected $timeout = 20; // Expired in : 20 minutes

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = $request->session()->get('last_activity_time');
            $currentTime = now();

            // If the session has expired, log out the user
            if ($lastActivity && $currentTime->diffInMinutes($lastActivity) > $this->timeout) {
                return redirect('/signout')->withErrors('Your session has expired due to inactivity.');
            }

            // Update the last activity time
            $request->session()->put('last_activity_time', $currentTime);
        }

        return $next($request);
    }
}
