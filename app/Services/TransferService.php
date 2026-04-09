<?php

namespace App\Services;

use App\Models\Transfer;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\Wallet;
use DomainException;
use Illuminate\Support\Facades\DB;

class TransferService
{
    public function transfer(User $sender, string $recipientEmail, float $value): Transfer
    {
        if ($value <= 0) {
            throw new DomainException('O valor da transferência deve ser maior que zero.');
        }

        return DB::transaction(function () use ($sender, $recipientEmail, $value) {
            $sender = User::with('wallet')->findOrFail($sender->id);

            $recipient = User::with('wallet')
                ->where('email', $recipientEmail)
                ->first();

            if (! $recipient) {
                throw new DomainException('Destinatário não encontrado.');
            }

            if ($sender->id === $recipient->id) {
                throw new DomainException('Você não pode transferir para si mesmo.');
            }

            $senderWallet = Wallet::where('user_id', $sender->id)
                ->lockForUpdate()
                ->first();

            $recipientWallet = Wallet::where('user_id', $recipient->id)
                ->lockForUpdate()
                ->first();

            if (! $senderWallet) {
                throw new DomainException('A carteira do remetente não foi encontrada.');
            }

            if (! $recipientWallet) {
                throw new DomainException('A carteira do destinatário não foi encontrada.');
            }

            if ((float) $senderWallet->balance < $value) {
                throw new DomainException('Saldo insuficiente para realizar a transferência.');
            }

            $senderWallet->balance -= $value;
            $recipientWallet->balance += $value;

            $senderWallet->save();
            $recipientWallet->save();

            $transfer = Transfer::create([
                'sender_id' => $sender->id,
                'recipient_id' => $recipient->id,
                'value' => $value,
            ]);

            TransactionHistory::create([
                'user_id' => $sender->id,
                'wallet_id' => $senderWallet->id,
                'transfer_id' => $transfer->id,
                'value' => $value,
                'description' => 'Transferência enviada para ' . $recipient->email,
            ]);

            TransactionHistory::create([
                'user_id' => $recipient->id,
                'wallet_id' => $recipientWallet->id,
                'transfer_id' => $transfer->id,
                'value' => $value,
                'description' => 'Transferência recebida de ' . $sender->email,
            ]);

            return $transfer;
        });
    }
}