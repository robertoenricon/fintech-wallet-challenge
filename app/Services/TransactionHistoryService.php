<?php

namespace App\Services;

use App\Models\TransactionHistory;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
}