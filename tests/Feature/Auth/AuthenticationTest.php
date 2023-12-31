<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'token',
            'user'
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->postJson('api/v1/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $loginResponse = $this->postJson('api/v1/login',[
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $headers = ['Authorization' => 'Bearer ' . $loginResponse->collect()['token']];

        $loginResponse->assertStatus(200);

        $response = $this->postJson('api/v1/logout',[],$headers);
        $response->assertStatus(200);
    }
}
