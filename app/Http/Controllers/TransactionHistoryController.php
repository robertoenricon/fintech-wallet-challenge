<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = TransactionHistory::with([
                'transfer.sender:id,name,email',
                'transfer.recipient:id,name,email',
            ])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $transactions = $query->paginate(10)->withQueryString();

        return view('transactions.index', ['transactions' => $transactions]);
    }
}