<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class AdminLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('admin_locale', config('app.locale', 'ar'));

        if (! in_array($locale, ['en', 'ar'], true)) {
            $locale = config('app.locale', 'ar');
        }

        if (! in_array($locale, ['en', 'ar'], true)) {
            $locale = 'ar';
        }

        App::setLocale($locale);

        return $next($request);
    }
}
