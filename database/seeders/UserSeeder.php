<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('admin'),
        ]);

        $user->wallet()->create([
            'balance' => 1000.00,
        ]);

        User::factory(9)
            ->has(Wallet::factory()->state(['balance' => fake()->randomFloat(2, 100, 5000)]), 'wallet')
            ->create();
    }
}