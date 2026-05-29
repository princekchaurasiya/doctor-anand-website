<?php

use App\Support\Api\ApiExceptionRenderer;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->context(function (): array {
            if (app()->runningInConsole() || ! app()->bound('request')) {
                return [];
            }

            try {
                $request = request();

                return [
                    'request_url' => $request->fullUrl(),
                    'request_method' => $request->method(),
                    'user_agent' => mb_substr((string) $request->userAgent(), 0, 512),
                ];
            } catch (Throwable) {
                return [];
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            return ApiExceptionRenderer::render($request, $e);
        });
    })->create();
