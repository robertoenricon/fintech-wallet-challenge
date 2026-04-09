<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionHistoryIndexRequest;

use App\Services\TransactionHistoryService;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionHistoryController extends BaseController
{
    protected TransactionHistoryService $transactionHistoryService;

    public function __construct(TransactionHistoryService $transactionHistoryService)
    {
        $this->transactionHistoryService = $transactionHistoryService;
    }

    public function index(TransactionHistoryIndexRequest $request): View
    {
        $transactions = $this->transactionHistoryService->paginateForUser(
            Auth::user(),
            $request->validated()
        );

        return view('transactions.index', ['transactions' => $transactions]);
    }
}
