<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Keep default `web` / `api` groups from Illuminate\Foundation\Configuration\Middleware.
        // Do not append AdminLocale here — it runs only on the Filament panel stack.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
