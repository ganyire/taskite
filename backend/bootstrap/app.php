<?php

use App\Services\HttpResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/apiv1.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: "api/v1",
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (
            Throwable $exception,
        ) {
            $isTestingEnvironment = app()->environment('testing');
            if ($exception instanceof ValidationException) {
                $keyedErrors = $exception->errors();
                $flattenedErrors = Arr::flatten($exception->errors());
                return HttpResponse::error(
                    data: $isTestingEnvironment ? $keyedErrors : $flattenedErrors,
                    httpCode: JsonResponse::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            if ($exception instanceof AuthenticationException) {
                return HttpResponse::error(
                    data: 'You are not authenticated.',
                    httpCode: JsonResponse::HTTP_UNAUTHORIZED
                );
            }

            return HttpResponse::error(
                data: $exception->getMessage(),
            );
        });
    })->create();
