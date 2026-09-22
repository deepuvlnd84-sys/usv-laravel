<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use Illuminate\Support\Facades\Session;

class TournamentController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
    }

    // Display all tournaments
    public function index()
    {
        $tournaments = Tournament::orderBy('created_at', 'asc')->get();
        $isAdmin = $this->checkAdmin();

        return view('tournaments.index', compact('tournaments', 'isAdmin'));
    }

    // Display single tournament details with Teams, Fixtures, Point Table, Leaderboard, Committee, and Gallery
    public function show($id)
    {
        if (is_numeric($id)) {
            $tournament = Tournament::findOrFail($id);
        } else {
            $queryName = str_replace('-', ' ', $id);
            $tournament = Tournament::where('name', 'like', "%{$queryName}%")->firstOrFail();
        }

        $isAdmin = $this->checkAdmin();
        $allTournaments = Tournament::orderBy('created_at', 'asc')->get();
        $data = $this->getTournamentDetailsData($tournament);

        return view('tournaments.show', array_merge([
            'tournament' => $tournament,
            'isAdmin' => $isAdmin,
            'allTournaments' => $allTournaments,
        ], $data));
    }

    private function getTournamentDetailsData($tournament)
    {
        $tournName = $tournament->name;

        // Customise teams based on tournament or provide exciting USV franchise squads
        $teams = [
            [
                'id' => 1,
                'name' => 'Vellanad Strikers',
                'short_name' => 'VS',
                'captain' => 'Bipin B. S.',
                'vice_captain' => 'Midhun Mohan',
                'primary_color' => '#e60000',
                'secondary_color' => '#ff5555',
                'squad_count' => 15,
                'home_ground' => 'Vellanad Oval',
                'squad' => ['Bipin B. S. (C)', 'Midhun Mohan (VC)', 'Deepu V.', 'Rahul Nair', 'Renjith R.', 'Sarath Kumar', 'Vipin Das', 'Vishnu Prasad', 'Arun C.', 'Akhil S.', 'Sujith S.', 'Kiran Raj', 'Sreejith M.', 'Jithin K.', 'Pradeep S.'],
            ],
            [
                'id' => 2,
                'name' => 'USV Royals',
                'short_name' => 'UR',
                'captain' => 'Akhil S. Kumar',
                'vice_captain' => 'Rahul R. Nair',
                'primary_color' => '#1a56db',
                'secondary_color' => '#60a5fa',
                'squad_count' => 15,
                'home_ground' => 'Vellanad Central Ground',
                'squad' => ['Akhil S. Kumar (C)', 'Rahul R. Nair (VC)', 'Anil Kumar M.', 'Harikrishnan', 'Manu Mohan', 'Gokul G.', 'Anandhu A.', 'Abhilash S.', 'Sreekanth P.', 'Aneesh R.', 'Naveen N.', 'Rajesh R.', 'Vineeth V.', 'Subhash B.', 'Dipin D.'],
            ],
            [
                'id' => 3,
                'name' => 'Vellanad Warriors',
                'short_name' => 'VW',
                'captain' => 'Vipin Das',
                'vice_captain' => 'Sarath S.',
                'primary_color' => '#16a34a',
                'secondary_color' => '#4ade80',
                'squad_count' => 14,
                'home_ground' => 'USV Arena Ground',
                'squad' => ['Vipin Das (C)', 'Sarath S. (VC)', 'Praveen P.', 'Santhosh S.', 'Shyam Kumar', 'Nidhin N.', 'Arjun Mohan', 'Binu B.', 'Sunil S.', 'Ratheesh R.', 'Ajith A.', 'Kishore K.', 'Shaji S.', 'Dhanush D.'],
            ],
            [
                'id' => 4,
                'name' => 'USV Titans',
                'short_name' => 'UT',
                'captain' => 'Renjith R.',
                'vice_captain' => 'Vishnu Prasad',
                'primary_color' => '#d97706',
                'secondary_color' => '#fbbf24',
                'squad_count' => 14,
                'home_ground' => 'Vellanad Sports Complex',
                'squad' => ['Renjith R. (C)', 'Vishnu Prasad (VC)', 'Anoop A.', 'Gireesh G.', 'Syam S.', 'Prasanth P.', 'Manoj M.', 'Shibu S.', 'Vinod V.', 'Ramesh R.', 'Bijoy B.', 'Jayesh J.', 'Baiju B.', 'Suresh S.'],
            ],
        ];

        // Fixtures Schedule
        $fixtures = [
            [
                'match_no' => 1,
                'stage' => 'Group Stage &bull; Match 1',
                'date' => '15 Oct 2026',
                'time' => '09:00 AM IST',
                'venue' => $tournament->venue ?? 'Vellanad Stadium',
                'team1' => 'Vellanad Strikers',
                'team1_short' => 'VS',
                'team1_score' => '168/6 (20.0)',
                'team2' => 'USV Royals',
                'team2_short' => 'UR',
                'team2_score' => '162/9 (20.0)',
                'status' => 'Completed',
                'result' => 'Vellanad Strikers won by 6 runs &bull; MoM: Bipin B. S. (68 off 42)',
            ],
            [
                'match_no' => 2,
                'stage' => 'Group Stage &bull; Match 2',
                'date' => '16 Oct 2026',
                'time' => '02:00 PM IST',
                'venue' => $tournament->venue ?? 'Vellanad Stadium',
                'team1' => 'Vellanad Warriors',
                'team1_short' => 'VW',
                'team1_score' => '155/7 (20.0)',
                'team2' => 'USV Titans',
                'team2_short' => 'UT',
                'team2_score' => '156/4 (18.4)',
                'status' => 'Completed',
                'result' => 'USV Titans won by 6 wickets &bull; MoM: Renjith R. (3/18 & 44*)',
            ],
            [
                'match_no' => 3,
                'stage' => 'Group Stage &bull; Match 3',
                'date' => '18 Oct 2026',
                'time' => '09:30 AM IST',
                'venue' => $tournament->venue ?? 'Vellanad Stadium',
                'team1' => 'Vellanad Strikers',
                'team1_short' => 'VS',
                'team1_score' => '182/4 (20.0)',
                'team2' => 'USV Titans',
                'team2_short' => 'UT',
                'team2_score' => '134/8 (15.2)',
                'status' => 'Ongoing',
                'result' => 'USV Titans need 49 runs in 28 balls (Live on CricHeroes)',
            ],
            [
                'match_no' => 4,
                'stage' => 'Group Stage &bull; Match 4',
                'date' => '20 Oct 2026',
                'time' => '02:00 PM IST',
                'venue' => $tournament->venue ?? 'Vellanad Stadium',
                'team1' => 'USV Royals',
                'team1_short' => 'UR',
                'team1_score' => null,
                'team2' => 'Vellanad Warriors',
                'team2_short' => 'VW',
                'team2_score' => null,
                'status' => 'Upcoming',
                'result' => 'Match starts at 2:00 PM IST &bull; Toss at 1:30 PM',
            ],
            [
                'match_no' => 5,
                'stage' => 'Semi Final 1',
                'date' => '24 Oct 2026',
                'time' => '09:30 AM IST',
                'venue' => $tournament->venue ?? 'Vellanad Stadium',
                'team1' => 'Rank #1 Team',
                'team1_short' => 'TBD',
                'team1_score' => null,
                'team2' => 'Rank #4 Team',
                'team2_short' => 'TBD',
                'team2_score' => null,
                'status' => 'Upcoming',
                'result' => 'Knockout Stage &bull; Winner qualifies for Grand Final',
            ],
            [
                'match_no' => 6,
                'stage' => 'Grand Final',
                'date' => '26 Oct 2026',
                'time' => '02:00 PM IST',
                'venue' => $tournament->venue ?? 'Vellanad Stadium',
                'team1' => 'Finalist 1',
                'team1_short' => 'TBD',
                'team1_score' => null,
                'team2' => 'Finalist 2',
                'team2_short' => 'TBD',
                'team2_score' => null,
                'status' => 'Upcoming',
                'result' => 'Championship Trophy Match &bull; Prize Distribution Ceremony',
            ],
        ];

        // Points Table Standings
        $points = [
            ['pos' => 1, 'team' => 'Vellanad Strikers', 'short' => 'VS', 'p' => 2, 'w' => 2, 'l' => 0, 'nr' => 0, 'nrr' => '+1.250', 'pts' => 4, 'form' => ['W', 'W']],
            ['pos' => 2, 'team' => 'USV Titans', 'short' => 'UT', 'p' => 2, 'w' => 1, 'l' => 1, 'nr' => 0, 'nrr' => '+0.420', 'pts' => 2, 'form' => ['W', 'L']],
            ['pos' => 3, 'team' => 'USV Royals', 'short' => 'UR', 'p' => 1, 'w' => 0, 'l' => 1, 'nr' => 0, 'nrr' => '-0.300', 'pts' => 0, 'form' => ['L']],
            ['pos' => 4, 'team' => 'Vellanad Warriors', 'short' => 'VW', 'p' => 1, 'w' => 0, 'l' => 1, 'nr' => 0, 'nrr' => '-1.370', 'pts' => 0, 'form' => ['L']],
        ];

        // Leaderboard Statistics
        $leaderboard = [
            'batsmen' => [
                ['rank' => 1, 'name' => 'Bipin B. S.', 'team' => 'Vellanad Strikers', 'runs' => 142, 'inn' => 2, 'hs' => '74*', 'avg' => '142.0', 'sr' => '165.1'],
                ['rank' => 2, 'name' => 'Akhil S. Kumar', 'team' => 'USV Royals', 'runs' => 96, 'inn' => 2, 'hs' => '62', 'avg' => '48.0', 'sr' => '141.2'],
                ['rank' => 3, 'name' => 'Renjith R.', 'team' => 'USV Titans', 'runs' => 88, 'inn' => 2, 'hs' => '48*', 'avg' => '44.0', 'sr' => '137.5'],
                ['rank' => 4, 'name' => 'Rahul R. Nair', 'team' => 'USV Royals', 'runs' => 79, 'inn' => 2, 'hs' => '51', 'avg' => '39.5', 'sr' => '127.4'],
                ['rank' => 5, 'name' => 'Deepu Vellanad', 'team' => 'Vellanad Strikers', 'runs' => 65, 'inn' => 2, 'hs' => '41*', 'avg' => '65.0', 'sr' => '154.8'],
            ],
            'bowlers' => [
                ['rank' => 1, 'name' => 'Vishnu Prasad', 'team' => 'USV Titans', 'wickets' => 6, 'overs' => '8.0', 'econ' => '5.62', 'best' => '4/18'],
                ['rank' => 2, 'name' => 'Midhun Mohan', 'team' => 'Vellanad Strikers', 'wickets' => 5, 'overs' => '7.4', 'econ' => '6.13', 'best' => '3/15'],
                ['rank' => 3, 'name' => 'Vipin Das', 'team' => 'Vellanad Warriors', 'wickets' => 4, 'overs' => '8.0', 'econ' => '6.75', 'best' => '3/22'],
                ['rank' => 4, 'name' => 'Harikrishnan', 'team' => 'USV Royals', 'wickets' => 3, 'overs' => '6.0', 'econ' => '7.00', 'best' => '2/19'],
                ['rank' => 5, 'name' => 'Sarath S.', 'team' => 'Vellanad Warriors', 'wickets' => 3, 'overs' => '7.0', 'econ' => '7.28', 'best' => '2/24'],
            ],
        ];

        // Tournament Organizing Committee
        $committee = [
            ['role' => 'Tournament Chairman', 'name' => 'Deepu Vellanad', 'phone' => '+91 94470 12345'],
            ['role' => 'General Convener', 'name' => 'Sujith S.', 'phone' => '+91 94470 67890'],
            ['role' => 'Chief Match Referee', 'name' => 'Anil Kumar M.', 'phone' => '+91 98471 11001'],
            ['role' => 'Umpires & Technical In-charge', 'name' => 'Rahul R. Nair', 'phone' => '+91 98472 22002'],
            ['role' => 'Ground & Pitch Curator', 'name' => 'Vipin Das', 'phone' => '+91 98473 33003'],
            ['role' => 'Live Scoring & Analytics Lead', 'name' => 'Arun Chandran', 'phone' => '+91 98474 44004'],
            ['role' => 'Player Welfare & Medical In-charge', 'name' => 'Renjith R.', 'phone' => '+91 98477 77007'],
        ];

        // Tournament Gallery Photos
        $gallery = [
            ['title' => 'Trophy Unveiling', 'tag' => 'Ceremony', 'desc' => "Grand official unveiling of {$tournName} trophy"],
            ['title' => 'Captains Meet & Toss', 'tag' => 'Opening', 'desc' => 'Captains assembly and pre-tournament briefing'],
            ['title' => 'Opening Match Action', 'tag' => 'Match Day', 'desc' => 'Electric moments from the first ball of the tournament'],
            ['title' => 'Winning Celebration', 'tag' => 'Momentum', 'desc' => 'Team celebrations and dugout cheers in the stadium'],
            ['title' => 'Player of the Match Award', 'tag' => 'Awards', 'desc' => 'Presentation ceremony honoring outstanding performances'],
            ['title' => 'Spectators & Fans', 'tag' => 'Atmosphere', 'desc' => 'Vibrant supporters cheering from the pavilion stands'],
        ];

        return compact('teams', 'fixtures', 'points', 'leaderboard', 'committee', 'gallery');
    }


    // Store a new tournament (Admin only)
    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('tournaments.index')
                ->withErrors(['admin' => 'Only Admin has permission to add tournament details.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'edition' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|string|in:Upcoming,Ongoing,Completed',
        ]);

        Tournament::create([
            'name' => $request->name,
            'edition' => $request->edition,
            'venue' => $request->venue,
            'start_date' => $request->start_date,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tournaments.index')
            ->with('success', "Tournament '{$request->name}' added successfully!");
    }

    // Update existing tournament (Admin only)
    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('tournaments.index')
                ->withErrors(['admin' => 'Only Admin has permission to manage tournament details.']);
        }

        $tournament = Tournament::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'edition' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'description' => 'nullable|string|max:2000',
            'status' => 'required|string|in:Upcoming,Ongoing,Completed',
        ]);

        $tournament->update([
            'name' => $request->name,
            'edition' => $request->edition,
            'venue' => $request->venue,
            'start_date' => $request->start_date,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tournaments.index')
            ->with('success', "Tournament '{$tournament->name}' updated successfully!");
    }

    // Delete tournament (Admin only)
    public function destroy($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('tournaments.index')
                ->withErrors(['admin' => 'Only Admin has permission to delete tournaments.']);
        }

        $tournament = Tournament::findOrFail($id);
        $name = $tournament->name;
        $tournament->delete();

        return redirect()->route('tournaments.index')
            ->with('success', "Tournament '{$name}' deleted successfully!");
    }
}
