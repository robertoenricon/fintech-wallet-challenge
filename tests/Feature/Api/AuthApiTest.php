<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_validates_required_fields(): void
    {
        $response = $this->postJson(route('api.auth.register'), []);

        $response
            ->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Os dados informados são inválidos.')
            ->assertJsonValidationErrors([
                'name',
                'email',
                'password',
            ]);
    }

    public function test_user_can_transfer_money(): void
    {
        /** @var User $sender */
        $sender = User::factory()->create();
        /** @var User $recipient */
        $recipient = User::factory()->create();

        $sender->wallet()->update(['balance' => 1000]);
        $recipient->wallet()->update(['balance' => 1000]);

        $response = $this->actingAs($sender)
            ->postJson(route('transfers.store'), [
                'email' => $recipient->email,
                'value' => 100,
            ]);

        $response
            ->assertCreated()
            ->assertJsonPath('message', 'Transferência realizada com sucesso.')
            ->assertJsonPath('data.value', 100);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $sender->id,
            'balance' => 900,
        ]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $recipient->id,
            'balance' => 1100,
        ]);
    }
}
