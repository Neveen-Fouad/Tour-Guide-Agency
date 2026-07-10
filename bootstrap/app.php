<?php
use Illuminate\Http\Request;

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\JwtVerify;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
        'jwt.verify' => JwtVerify::class,
        'admin' => IsAdmin::class, 
    ]);
    })
->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, Request $request) {
            
            // Get the code from the exception
            $code = $e->getCode();
            
            // If it's a valid numeric HTTP code, cast to int. Otherwise, force it to 500.
            $status = (is_numeric($code) && $code >= 100 && $code <= 599) ? (int) $code : 500;
            
            return response()->json([
                'message' => $e->getMessage()
            ], $status);
        });
    })->create();