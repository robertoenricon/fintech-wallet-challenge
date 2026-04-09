<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Services\TransferService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TransferController extends Controller
{
    private TransferService $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function store(TransferRequest $request): JsonResponse
    {
        try {
            $transfer = $this->transferService->transfer(
                Auth::user(),
                $request->input('email'),
                (float) $request->input('value')
            );

            return response()->json([
                'message' => 'Transferência realizada com sucesso.',
                'data' => [
                    'transfer_id' => $transfer->id,
                    'value' => $transfer->value,
                ],
            ], 201);

        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);

        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Não foi possível realizar a transferência.',
            ], 500);
        }
    }
}