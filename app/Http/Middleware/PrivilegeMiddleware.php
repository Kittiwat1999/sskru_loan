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
    public function handle(Request $request, Closure $next, $privilege1, $privilege2 = null): Response
    {
        $privilege = [$privilege1, $privilege2];
        if($request->session()->get('privilege') == '' || !in_array($request->session()->get('privilege'), $privilege)){
            abort(404);
        }
        return $next($request);
    }
}
