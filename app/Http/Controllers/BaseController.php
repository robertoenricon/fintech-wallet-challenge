<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class BaseController
{
    protected function successResponse(
        mixed $data = null,
        string $message = 'Requisição realizada com sucesso.',
        int $status = 200
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'error' => null,
        ], $status);
    }

    protected function errorResponse(
        string $message = 'Não foi possível processar a requisição.',
        mixed $error = null,
        int $status = 400
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'error' => $error,
        ], $status);
    }
}
