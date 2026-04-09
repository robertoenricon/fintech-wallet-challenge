<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 1000.00,
            ]);
        });
    }
}
