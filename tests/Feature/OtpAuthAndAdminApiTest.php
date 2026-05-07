<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OtpAuthAndAdminApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_register(): void
    {
        $response = $this->postJson('/api/auth/client/register', [
            'name' => 'Client One',
            'phone' => '2012345678',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.role', User::ROLE_CLIENT)
            ->assertJsonPath('data.phone', '2012345678');
    }

    public function test_user_can_verify_otp_and_receive_token(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_CLIENT,
            'otp_code' => Hash::make('123456'),
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->postJson('/api/auth/otp/verify', [
            'phone' => $user->phone,
            'otp' => '123456',
        ]);

        $response->assertOk()
            ->assertJsonStructure(['token', 'token_type', 'abilities', 'data']);
    }

    public function test_admin_can_filter_and_search_clients(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        User::factory()->create([
            'name' => 'John Client',
            'phone' => '5551234567',
            'role' => User::ROLE_CLIENT,
        ]);

        User::factory()->create([
            'name' => 'Jane Person',
            'phone' => '5557654321',
            'role' => User::ROLE_CLIENT,
        ]);

        Sanctum::actingAs($admin);

        $response = $this->getJson('/api/clients?q=555123&sort_by=name&sort_dir=asc&per_page=10');

        $response->assertOk()
            ->assertJsonPath('data.0.phone', '5551234567');
    }
}
