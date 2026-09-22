<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tournament;
use App\Models\ScrollingMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_loads_successfully()
    {
        $response = $this->get('/login/admin');
        $response->assertStatus(200);
        $response->assertSee('ADMIN PORTAL');
        $response->assertSee('Log In as Admin');
    }

    public function test_admin_login_with_valid_credentials_succeeds()
    {
        $this->withSession(['admin_captcha_result' => 15]);

        $response = $this->post('/login/admin', [
            'username' => 'Admin',
            'password' => 'USV@123',
            'captcha' => 15,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('Admin', session('authenticated_user'));
        $this->assertTrue(session('is_admin'));
    }

    public function test_admin_login_is_case_insensitive_for_username()
    {
        $this->withSession(['admin_captcha_result' => 20]);

        $response = $this->post('/login/admin', [
            'username' => 'admin',
            'password' => 'USV@123',
            'captcha' => 20,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('Admin', session('authenticated_user'));
        $this->assertTrue(session('is_admin'));
    }

    public function test_admin_login_with_invalid_password_fails()
    {
        $this->withSession(['admin_captcha_result' => 15]);

        $response = $this->post('/login/admin', [
            'username' => 'Admin',
            'password' => 'WrongPassword',
            'captcha' => 15,
        ]);

        $response->assertSessionHasErrors('auth');
        $this->assertNull(session('authenticated_user'));
        $this->assertFalse(session('is_admin', false));
    }

    public function test_admin_can_manage_tournaments()
    {
        // 1. Create tournament
        $createResponse = $this->withSession(['authenticated_user' => 'Admin', 'is_admin' => true])
            ->post('/tournaments', [
                'name' => 'Monsoon Cup 2026',
                'description' => 'Annual regional tournament',
                'edition' => 'Edition 2026',
                'status' => 'Upcoming',
                'venue' => 'Vellanad Oval Ground',
            ]);

        $createResponse->assertRedirect(route('tournaments.index'));
        $createResponse->assertSessionHas('success');

        $tournament = Tournament::where('name', 'Monsoon Cup 2026')->first();
        $this->assertNotNull($tournament);
        $this->assertEquals('Upcoming', $tournament->status);

        // 2. Update tournament
        $updateResponse = $this->withSession(['authenticated_user' => 'Admin', 'is_admin' => true])
            ->put('/tournaments/' . $tournament->id, [
                'name' => 'Monsoon Super Cup 2026',
                'description' => 'Updated tournament description',
                'edition' => 'Special Edition',
                'status' => 'Ongoing',
                'venue' => 'Vellanad Turf Arena',
            ]);

        $updateResponse->assertRedirect(route('tournaments.index'));
        $tournament->refresh();
        $this->assertEquals('Monsoon Super Cup 2026', $tournament->name);
        $this->assertEquals('Ongoing', $tournament->status);

        // 3. Delete tournament
        $deleteResponse = $this->withSession(['authenticated_user' => 'Admin', 'is_admin' => true])
            ->delete('/tournaments/' . $tournament->id);

        $deleteResponse->assertRedirect(route('tournaments.index'));
        $this->assertNull(Tournament::find($tournament->id));
    }

    public function test_non_admin_cannot_manage_tournaments()
    {
        $tournament = Tournament::create([
            'name' => 'Protected Tournament',
            'status' => 'Upcoming',
        ]);

        // Guest store
        $this->post('/tournaments', ['name' => 'Hacked Tournament', 'status' => 'Upcoming'])
            ->assertRedirect(route('tournaments.index'))
            ->assertSessionHasErrors('admin');

        // Player store
        $this->withSession(['authenticated_user' => 'player@example.com', 'is_admin' => false])
            ->post('/tournaments', ['name' => 'Player Tournament', 'status' => 'Upcoming'])
            ->assertRedirect(route('tournaments.index'))
            ->assertSessionHasErrors('admin');

        // Player update
        $this->withSession(['authenticated_user' => 'player@example.com', 'is_admin' => false])
            ->put('/tournaments/' . $tournament->id, ['name' => 'Modified Tournament', 'status' => 'Completed'])
            ->assertRedirect(route('tournaments.index'))
            ->assertSessionHasErrors('admin');

        // Player delete
        $this->withSession(['authenticated_user' => 'player@example.com', 'is_admin' => false])
            ->delete('/tournaments/' . $tournament->id)
            ->assertRedirect(route('tournaments.index'))
            ->assertSessionHasErrors('admin');
    }

    public function test_admin_can_manage_scrolling_messages()
    {
        $adminSession = ['authenticated_user' => 'Admin', 'is_admin' => true];

        // Store
        $storeResponse = $this->withSession($adminSession)
            ->post('/scrolling-messages', [
                'message' => 'Urgent match announcement!',
            ]);

        $storeResponse->assertRedirect();
        $storeResponse->assertSessionHas('success');
        $message = ScrollingMessage::where('message', 'Urgent match announcement!')->first();
        $this->assertNotNull($message);
        $this->assertTrue((bool)$message->is_active);

        // Toggle
        $this->withSession($adminSession)
            ->patch('/scrolling-messages/' . $message->id . '/toggle')
            ->assertRedirect();

        $message->refresh();
        $this->assertFalse((bool)$message->is_active);

        // Delete
        $this->withSession($adminSession)
            ->delete('/scrolling-messages/' . $message->id)
            ->assertRedirect();

        $this->assertNull(ScrollingMessage::find($message->id));
    }

    public function test_non_admin_cannot_manage_scrolling_messages()
    {
        $message = ScrollingMessage::create([
            'message' => 'Admin Broadcast',
            'is_active' => true,
        ]);

        $playerSession = ['authenticated_user' => 'player@example.com', 'is_admin' => false];

        // Player edit page
        $this->withSession($playerSession)
            ->get('/scrolling-messages/edit')
            ->assertRedirect(route('login.admin'))
            ->assertSessionHasErrors('auth');

        // Player store
        $this->withSession($playerSession)
            ->post('/scrolling-messages', ['message' => 'Fake Message'])
            ->assertRedirect(route('login.admin'))
            ->assertSessionHasErrors('auth');

        // Player toggle
        $this->withSession($playerSession)
            ->patch('/scrolling-messages/' . $message->id . '/toggle')
            ->assertRedirect(route('login.admin'))
            ->assertSessionHasErrors('auth');

        // Player delete
        $this->withSession($playerSession)
            ->delete('/scrolling-messages/' . $message->id)
            ->assertRedirect(route('login.admin'))
            ->assertSessionHasErrors('auth');
    }

    public function test_logout_clears_admin_session()
    {
        $response = $this->withSession(['authenticated_user' => 'Admin', 'is_admin' => true])
            ->post('/logout');

        $response->assertRedirect(route('login'));
        $this->assertNull(session('authenticated_user'));
        $this->assertNull(session('is_admin'));
    }
}
