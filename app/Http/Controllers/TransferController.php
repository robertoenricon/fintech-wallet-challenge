<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Services\TransferService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Throwable;

class TransferController extends BaseController
{
    private TransferService $transferService;

    public function __construct(TransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    public function index(): View
    {
        $user = Auth::user();

        $transfers = $this->transferService
            ->listForUser($user, 10)
            ->map(function ($transfer) use ($user) {
                $isSender = (int) $transfer->sender_id === (int) $user->id;
                $counterparty = $isSender ? $transfer->recipient : $transfer->sender;

                return [
                    'id' => $transfer->id,
                    'direction' => $isSender ? 'sent' : 'received',
                    'value' => (float) $transfer->value,
                    'created_at' => $transfer->created_at?->toIso8601String(),
                    'counterparty' => $counterparty ? [
                        'name' => $counterparty->name,
                        'email' => $counterparty->email,
                    ] : null,
                ];
            })
            ->values();

        return view('transfers.index', [
            'transfers' => $transfers,
        ]);
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
