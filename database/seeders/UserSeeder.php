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
        $user = User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('admin'),
            ]
        );

        $user->wallet()->updateOrCreate(
            ['user_id' => $user->id],
            ['balance' => 1000.00]
        );

        if (User::query()->count() <= 1) {
            User::factory(9)
                ->has(Wallet::factory()->state(['balance' => fake()->randomFloat(2, 100, 5000)]), 'wallet')
                ->create();
        }
    }
}
