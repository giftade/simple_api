<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // For 422 Unprocessable Entity
use Illuminate\Auth\AuthenticationException; // For 401 Unauthorized
use Illuminate\Auth\Access\AuthorizationException; // Another common source of 403 Forbidden
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; // For 404 Not Found
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException; // For 403 Forbidden
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException; // For 405 Method Not Allowed
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException; // For 400 Bad Request
use Symfony\Component\HttpKernel\Exception\HttpException; // Generic HTTP Exception

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void
    {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void
    {

    })->create();