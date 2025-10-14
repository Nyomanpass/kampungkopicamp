<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Ambil 'locale' (bahasa) dari Session Laravel.
        $locale = Session::get('locale', config('app.locale')); 
        
        // 2. KRUSIAL: Atur locale Laravel secara global untuk permintaan ini.
        App::setLocale($locale);

        return $next($request);
    }
}
