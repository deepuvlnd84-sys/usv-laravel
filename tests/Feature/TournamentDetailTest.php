<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Tournament;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TournamentDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_tournaments_index_displays_quick_access_and_detail_links()
    {
        $response = $this->get(route('tournaments.index'));
        $response->assertStatus(200);

        // Check for the three required tournaments
        $response->assertSee('Premier League');
        $response->assertSee('Champions League');
        $response->assertSee('Discovery League');

        // Check links to tournament detail pages
        $response->assertSee(route('tournaments.show', 1));
        $response->assertSee(route('tournaments.show', 2));
        $response->assertSee(route('tournaments.show', 3));

        // Check 'Enter Tournament Details' button text
        $response->assertSee('Enter Tournament Details');
    }

    public function test_premier_league_details_page_loads_with_all_six_buttons()
    {
        $response = $this->get(route('tournaments.show', 1));
        $response->assertStatus(200);

        // Header & Title
        $response->assertSee('Premier League');

        // Verify the 6 REQUIRED buttons from user specification
        $response->assertSee('TEAMS');
        $response->assertSee('FIXTURES');
        $response->assertSee('POINT TABLE');
        $response->assertSee('LEADERBOARD');
        $response->assertSee('TOURNAMENT COMMITTEE');
        $response->assertSee('GALLERY');

        // Verify Team contents
        $response->assertSee('Vellanad Strikers');
        $response->assertSee('USV Royals');
        $response->assertSee('Vellanad Warriors');
        $response->assertSee('USV Titans');

        // Verify Fixtures contents
        $response->assertSee('Match Schedule & Fixtures', false);

        // Verify Point Table contents
        $response->assertSee('POINT TABLE');
        $response->assertSee('NRR');
        $response->assertSee('PTS');

        // Verify Leaderboard contents
        $response->assertSee('ORANGE CAP');
        $response->assertSee('PURPLE CAP');

        // Verify Committee contents
        $response->assertSee('Tournament Chairman');
        $response->assertSee('General Convener');

        // Verify Gallery contents
        $response->assertSee('Trophy Unveiling');
        $response->assertSee('Captains Meet & Toss');
    }

    public function test_champions_league_details_page_loads_with_all_six_buttons()
    {
        $response = $this->get(route('tournaments.show', 2));
        $response->assertStatus(200);

        $response->assertSee('Champions League');
        $response->assertSee('TEAMS');
        $response->assertSee('FIXTURES');
        $response->assertSee('POINT TABLE');
        $response->assertSee('LEADERBOARD');
        $response->assertSee('TOURNAMENT COMMITTEE');
        $response->assertSee('GALLERY');
    }

    public function test_discovery_league_details_page_loads_with_all_six_buttons()
    {
        $response = $this->get(route('tournaments.show', 3));
        $response->assertStatus(200);

        $response->assertSee('Discovery League');
        $response->assertSee('TEAMS');
        $response->assertSee('FIXTURES');
        $response->assertSee('POINT TABLE');
        $response->assertSee('LEADERBOARD');
        $response->assertSee('TOURNAMENT COMMITTEE');
        $response->assertSee('GALLERY');
    }

    public function test_slug_urls_for_tournaments_work_properly()
    {
        $responsePremier = $this->get('/tournaments/premier-league');
        $responsePremier->assertStatus(200);
        $responsePremier->assertSee('Premier League');

        $responseChampions = $this->get('/tournaments/champions-league');
        $responseChampions->assertStatus(200);
        $responseChampions->assertSee('Champions League');

        $responseDiscovery = $this->get('/tournaments/discovery-league');
        $responseDiscovery->assertStatus(200);
        $responseDiscovery->assertSee('Discovery League');
    }

    public function test_home_page_and_header_navbars_include_tournaments_dropdown()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response->assertSee(route('tournaments.show', 1));
        $response->assertSee(route('tournaments.show', 2));
        $response->assertSee(route('tournaments.show', 3));
        $response->assertSee('Premier League');
        $response->assertSee('Champions League');
        $response->assertSee('Discovery League');
    }

    public function test_admin_can_update_tournament_details()
    {
        $tournament = Tournament::find(1);

        $response = $this->withSession([
            'authenticated_user' => 'deepuvlnd84@gmail.com',
            'is_admin' => true,
        ])->put(route('tournaments.update', $tournament->id), [
            'name' => 'Premier League 2026 Updated',
            'edition' => 'Season 2026 Edition',
            'venue' => 'Grand Stadium Vellanad',
            'start_date' => '2026-10-20',
            'description' => 'Updated championship description.',
            'status' => 'Ongoing',
        ]);

        $response->assertRedirect(route('tournaments.index'));
        $this->assertDatabaseHas('tournaments', [
            'id' => 1,
            'name' => 'Premier League 2026 Updated',
            'venue' => 'Grand Stadium Vellanad',
            'status' => 'Ongoing',
        ]);
    }

    public function test_non_admin_cannot_update_tournament_details()
    {
        $tournament = Tournament::find(1);

        $response = $this->put(route('tournaments.update', $tournament->id), [
            'name' => 'Unauthorized Name Change',
            'status' => 'Completed',
        ]);

        $response->assertRedirect(route('tournaments.index'));
        $response->assertSessionHasErrors('admin');

        $this->assertDatabaseMissing('tournaments', [
            'id' => 1,
            'name' => 'Unauthorized Name Change',
        ]);
    }
}
