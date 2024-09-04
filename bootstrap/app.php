<?php

use App\Http\Middleware\CheckVerified;
use App\Http\Middleware\EnsureUserRole;
use App\Http\Middleware\RedirectToAdmin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => EnsureUserRole::class,
            'redirect_to_admin' => RedirectToAdmin::class,
            'check.verified' => CheckVerified::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/midtrans-callback'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
