<?php

namespace App\Http\Controllers;

use App\Services\TransactionHistoryService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends BaseController
{
    public function __construct(
        private readonly TransactionHistoryService $transactionHistoryService
    ) {
    }

    public function index(): View
    {
        $user = Auth::user();

        return view('dashboard', [
            'user' => $user,
            'recentTransactions' => $this->transactionHistoryService->recentForUser($user),
        ]);
    }
}
