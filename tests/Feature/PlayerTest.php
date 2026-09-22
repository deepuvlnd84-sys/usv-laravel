<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Player;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;
    public function test_players_index_page_loads_successfully()
    {
        $response = $this->get('/players');
        $response->assertStatus(200);
        $response->assertSee('CLUB');
        $response->assertSee('MEMBERS');
        $response->assertDontSee('Total Squad');
    }

    public function test_members_route_loads_successfully()
    {
        $response = $this->get('/members');
        $response->assertStatus(200);
        $response->assertSee('CLUB');
        $response->assertSee('MEMBERS');
        $response->assertDontSee('Total Squad');
    }

    public function test_unauthenticated_user_cannot_store_player()
    {
        $response = $this->post('/players', [
            'name' => 'Guest Player',
            'jersey_number' => 99,
            'position' => 'BATSMAN',
        ]);

        $response->assertRedirect(route('players.index'));
        $response->assertSessionHasErrors('admin');
    }

    public function test_regular_player_cannot_modify_players()
    {
        $response = $this->withSession(['authenticated_user' => 'player@example.com', 'is_admin' => false])
            ->post('/players', [
                'name' => 'Hacked Player',
                'jersey_number' => 99,
                'position' => 'BATSMAN',
            ]);

        $response->assertRedirect(route('players.index'));
        $response->assertSessionHasErrors('admin');
    }

    public function test_admin_can_create_player_with_photo()
    {
        $photo = UploadedFile::fake()->image('test_player.jpg', 200, 200);

        $response = $this->withSession(['authenticated_user' => 'Admin', 'is_admin' => true])
            ->post('/players', [
                'name' => 'Test Hero',
                'jersey_number' => 77,
                'position' => 'ALL ROUNDER',
                'photo' => $photo,
            ]);

        $response->assertRedirect(route('players.index'));
        $response->assertSessionHas('success');

        $player = Player::where('name', 'Test Hero')->first();
        $this->assertNotNull($player);
        $this->assertEquals(77, $player->jersey_number);
        $this->assertNotNull($player->photo);
        $this->assertTrue(File::exists(public_path('uploads/players/' . $player->photo)));

        // Clean up test file and record
        File::delete(public_path('uploads/players/' . $player->photo));
        $player->delete();
    }

    public function test_admin_can_update_player()
    {
        $player = Player::create([
            'name' => 'Original Name',
            'jersey_number' => 11,
            'position' => 'BOWLER',
        ]);

        $response = $this->withSession(['authenticated_user' => 'Admin', 'is_admin' => true])
            ->put('/players/' . $player->id, [
                'name' => 'Updated Name',
                'jersey_number' => 12,
                'position' => 'ALL ROUNDER',
            ]);

        $response->assertRedirect(route('players.index'));
        $response->assertSessionHas('success');

        $player->refresh();
        $this->assertEquals('Updated Name', $player->name);
        $this->assertEquals(12, $player->jersey_number);
        $this->assertEquals('ALL ROUNDER', $player->position);

        $player->delete();
    }

    public function test_admin_can_delete_player()
    {
        $player = Player::create([
            'name' => 'Delete Me',
            'jersey_number' => 88,
            'position' => 'BATSMAN',
        ]);

        $response = $this->withSession(['authenticated_user' => 'Admin', 'is_admin' => true])
            ->delete('/players/' . $player->id);

        $response->assertRedirect(route('players.index'));
        $response->assertSessionHas('success');

        $this->assertNull(Player::find($player->id));
    }
}
