<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if (!$request->is('api/*')) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Os dados informados são inválidos.',
                'data' => null,
                'error' => $exception->errors(),
            ], 422);
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if (!$request->is('api/*')) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado.',
                'data' => null,
                'error' => ['auth' => ['Faça login para acessar este recurso.']],
            ], 401);
        });

        $exceptions->render(function (ModelNotFoundException|NotFoundHttpException $exception, Request $request) {
            if (!$request->is('api/*')) {
                return null;
            }

            return response()->json([
                'success' => false,
                'message' => 'Recurso não encontrado.',
                'data' => null,
                'error' => ['resource' => ['O recurso solicitado não foi encontrado.']],
            ], 404);
        });
    })->create();
