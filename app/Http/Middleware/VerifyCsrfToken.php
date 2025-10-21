<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Configuration\Middleware as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class VerifyCsrfToken extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    protected $except = [
        'payment/webhook',
        'payment/webhook/*',
    ];
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
