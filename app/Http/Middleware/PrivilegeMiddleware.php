<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PrivilegeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $privilege): Response
    {
        if($request->session()->get('privilege') == '' && $request->session()->get('privilege') != $privilege){
            return redirect('/');
        }
        return $next($request);
    }
}
