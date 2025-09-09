<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// bootstrap/app.php

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // AQUI É ONDE VOCÊ REGISTRA O APELIDO
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdminMiddleware::class,
        ]);

        // Pode haver outras configurações de middleware aqui...
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ...
    })->create();