<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\TransferController;
use App\Models\TransactionHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');

    Route::get('/register', 'showRegister')->name('register');
    Route::post('/register', 'register')->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        $recentTransactions = TransactionHistory::query()
            ->with([
                'transfer.sender:id,name,email',
                'transfer.recipient:id,name,email',
            ])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
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

        return view('dashboard', [
            'user' => $user,
            'recentTransactions' => $recentTransactions,
        ]);
    })->name('dashboard');
    Route::get('/transfers', [TransferController::class, 'index'])->name('transfers.index');
    Route::get('/transfers/create', function () {
        return view('transfers.create');
    })->name('transfers.create');
        
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/transfers', [TransferController::class, 'store'])->name('transfers.store');

    Route::get('/transactions', [TransactionHistoryController::class, 'index'])->name('transactions.index');
});
