<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ImportantMessage;
use App\Models\HomeFixture;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        User::firstOrCreate(
            ['email' => 'admin@usv.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Important Messages (Latest Club Updates / Announcements)
        if (class_exists(ImportantMessage::class)) {
            ImportantMessage::truncate();

            ImportantMessage::create([
                'title' => 'USV Premier League 2026 Registrations Open!',
                'message' => 'All senior players and members are requested to register before 10th October 2026. Online registration portal is live.',
                'badge' => 'URGENT',
            ]);

            ImportantMessage::create([
                'title' => 'Annual General Body Meeting Notice',
                'message' => 'The Annual General Body meeting of United Seniors Vellanad will be held on Sunday at 5:00 PM at Vellanad Club House.',
                'badge' => 'NOTICE',
            ]);

            ImportantMessage::create([
                'title' => 'Ground Practice Session Timings',
                'message' => 'Weekend practice sessions will commence from 6:30 AM every Saturday & Sunday at Vellanad Stadium.',
                'badge' => 'UPDATE',
            ]);
        }

        // 3. Home Fixtures (Premier League S5 Day 4 Matches)
        if (class_exists(HomeFixture::class)) {
            HomeFixture::truncate();

            HomeFixture::create([
                'match_no' => 'MATCH 1',
                'stage' => 'DAY 4',
                'team1' => 'DRAGONS XI',
                'team1_short' => 'DXI',
                'team1_score' => null,
                'team2' => 'SEAGULLS',
                'team2_short' => 'SGL',
                'team2_score' => null,
                'match_date' => '16-AUG-26',
                'match_time' => '7:00 AM',
                'venue' => 'Vellanad Stadium',
                'status' => 'Upcoming',
                'result' => 'Match Starts at 7:00 AM',
                'order_position' => 1,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 2',
                'stage' => 'DAY 4',
                'team1' => 'SUPER SIXERS',
                'team1_short' => 'SSX',
                'team1_score' => null,
                'team2' => 'RDX XI',
                'team2_short' => 'RDX',
                'team2_score' => null,
                'match_date' => '16-AUG-26',
                'match_time' => '7:00 AM',
                'venue' => 'Vellanad Stadium',
                'status' => 'Upcoming',
                'result' => 'Match Starts at 7:00 AM',
                'order_position' => 2,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 3',
                'stage' => 'DAY 4',
                'team1' => 'SARA ROYALS',
                'team1_short' => 'SRY',
                'team1_score' => null,
                'team2' => 'BLACK PANTHERS',
                'team2_short' => 'BPN',
                'team2_score' => null,
                'match_date' => '16-AUG-26',
                'match_time' => '7:00 AM',
                'venue' => 'Vellanad Stadium',
                'status' => 'Upcoming',
                'result' => 'Match Starts at 7:00 AM',
                'order_position' => 3,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 4',
                'stage' => 'DAY 4',
                'team1' => 'PRITHVI WARRIORS',
                'team1_short' => 'PWR',
                'team1_score' => null,
                'team2' => 'SEAGULLS',
                'team2_short' => 'SGL',
                'team2_score' => null,
                'match_date' => '16-AUG-26',
                'match_time' => '7:00 AM',
                'venue' => 'Vellanad Stadium',
                'status' => 'Upcoming',
                'result' => 'Match Starts at 7:00 AM',
                'order_position' => 4,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 5',
                'stage' => 'DAY 4',
                'team1' => 'SUPER SIXERS',
                'team1_short' => 'SSX',
                'team1_score' => null,
                'team2' => 'EVER-TEN',
                'team2_short' => 'EVT',
                'team2_score' => null,
                'match_date' => '16-AUG-26',
                'match_time' => '7:00 AM',
                'venue' => 'Vellanad Stadium',
                'status' => 'Upcoming',
                'result' => 'Match Starts at 7:00 AM',
                'order_position' => 5,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 6',
                'stage' => 'DAY 4',
                'team1' => 'RDX XI',
                'team1_short' => 'RDX',
                'team1_score' => null,
                'team2' => 'CTH XI',
                'team2_short' => 'CTH',
                'team2_score' => null,
                'match_date' => '16-AUG-26',
                'match_time' => '7:00 AM',
                'venue' => 'Vellanad Stadium',
                'status' => 'Upcoming',
                'result' => 'Match Starts at 7:00 AM',
                'order_position' => 6,
            ]);
        }
    }
}