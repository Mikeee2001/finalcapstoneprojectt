<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckUser;
use App\Http\Middleware\CheckVet;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        channels: __DIR__ . '/../routes/channels.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        // ✅ Correct global middleware
        $middleware->use([
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Http\Middleware\TrustProxies::class,

        ]);

        // ✅ Route middleware aliases
        $middleware->alias([
            'checkRole' => CheckRole::class,
            'admin' => CheckAdmin::class,
            'user' => CheckUser::class,
            'vet' => CheckVet::class,

        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
