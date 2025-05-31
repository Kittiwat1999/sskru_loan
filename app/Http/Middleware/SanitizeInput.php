<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();

        array_walk_recursive($input, function (&$value) {
            if (is_string($value)) {
                $value = preg_replace('/[\x{00A0}\x{200B}-\x{200D}\x{FEFF}\p{C}]/u', '', $value);
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                $value = iconv('UTF-8', 'UTF-8//IGNORE', $value);
            }
        });

        $request->merge($input);

        return $next($request);
    }
}
