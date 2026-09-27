<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_redirected_to_login()
    {
        $response = $this->get('/dashboard');
        $this->assertTrue($response->isRedirect());
    }

    public function test_authenticated_player_role_access()
    {
        $user = User::factory()->create([
            'role' => 'player',
        ]);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_authenticated_admin_role_access()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
    }
}
