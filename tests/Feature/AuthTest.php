<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_login(): void
    {
        $response = $this->postJson('api/login', [
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_can_register(): void
    {
        $response = $this->postJson('api/register', [
            'name' => 'zidane',
            'email' => 'zidane@example.com',
            'role' => 'user',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response
            ->assertStatus(201)
            ->assertJson([
                'name' => 'zidane',
                'email' => 'zidane@example.com',
                'role' => 'user',
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'zidane',
            'email' => 'zidane@example.com',
            'role' => 'user'
        ]);
    }

    public function test_can_logout(): void
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get('api/logout');

        $response->assertStatus(204);
    }
}
