<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionHistory extends Model
{

    public const TYPE_DEBIT = 'debit';
    public const TYPE_CREDIT = 'credit';

    protected $fillable = [
        'user_id',
        'wallet_id',
        'transfer_id',
        'type',
        'value',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }
}