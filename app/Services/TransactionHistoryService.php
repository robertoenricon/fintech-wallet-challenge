<?php

namespace App\Services;

use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class TransactionHistoryService
{
    public function paginateForUser(User $user, array $filters = []): LengthAwarePaginator
    {
        $query = TransactionHistory::query()
            ->with([
                'transfer.sender:id,name,email',
                'transfer.recipient:id,name,email',
            ])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at');

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        return $query->paginate(10)->withQueryString();
    }

    public function recentForUser(User $user, int $limit = 5): Collection
    {
        return TransactionHistory::query()
            ->with([
                'transfer.sender:id,name,email',
                'transfer.recipient:id,name,email',
            ])
            ->where('user_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function (TransactionHistory $transaction) {
                $transfer = $transaction->transfer;
                $involvedUser = null;

                if ($transfer) {
                    $involvedUser = $transaction->type === TransactionHistory::TYPE_DEBIT
                        ? $transfer->recipient
                        : $transfer->sender;
                }

                return [
                    'id' => $transaction->id,
                    'type' => $transaction->type,
                    'value' => (float) $transaction->value,
                    'description' => $transaction->description,
                    'created_at' => $transaction->created_at?->toIso8601String(),
                    'involved_user' => $involvedUser ? [
                        'name' => $involvedUser->name,
                        'email' => $involvedUser->email,
                    ] : null,
                ];
            })
            ->values();
    }
}
