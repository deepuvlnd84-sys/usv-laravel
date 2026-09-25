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

        // 3. Home Fixtures (Matches & Tournament Schedule)
        if (class_exists(HomeFixture::class)) {
            HomeFixture::truncate();

            HomeFixture::create([
                'match_no' => 'MATCH 1',
                'stage' => 'GROUP STAGE',
                'team1' => 'Vellanad Strikers',
                'team1_short' => 'VS',
                'team1_score' => '168/6 (20.0)',
                'team2' => 'USV Royals',
                'team2_short' => 'UR',
                'team2_score' => '162/9 (20.0)',
                'match_date' => '2026-10-15',
                'match_time' => '09:30 AM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'COMPLETED',
                'result' => 'Vellanad Strikers won by 6 runs',
                'order_position' => 1,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 2',
                'stage' => 'GROUP STAGE',
                'team1' => 'Vellanad Warriors',
                'team1_short' => 'VW',
                'team1_score' => '152/7 (20.0)',
                'team2' => 'USV Titans',
                'team2_short' => 'UT',
                'team2_score' => '156/4 (18.4)',
                'match_date' => '2026-10-16',
                'match_time' => '02:00 PM IST',
                'venue' => 'Vellanad Central Ground',
                'status' => 'COMPLETED',
                'result' => 'USV Titans won by 6 wickets',
                'order_position' => 2,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 3',
                'stage' => 'GROUP STAGE',
                'team1' => 'Vellanad Strikers',
                'team1_short' => 'VS',
                'team1_score' => '182/4 (20.0)',
                'team2' => 'USV Titans',
                'team2_short' => 'UT',
                'team2_score' => '134/8 (15.2)',
                'match_date' => '2026-10-18',
                'match_time' => '09:30 AM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'ONGOING',
                'result' => 'USV Titans need 49 runs in 28 balls',
                'order_position' => 3,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 4',
                'stage' => 'GROUP STAGE',
                'team1' => 'USV Royals',
                'team1_short' => 'UR',
                'team1_score' => null,
                'team2' => 'Vellanad Warriors',
                'team2_short' => 'VW',
                'team2_score' => null,
                'match_date' => '2026-10-20',
                'match_time' => '02:00 PM IST',
                'venue' => 'Vellanad Sports Complex',
                'status' => 'UPCOMING',
                'result' => 'Toss at 01:30 PM IST',
                'order_position' => 4,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 5',
                'stage' => 'SEMI FINAL 1',
                'team1' => 'Rank #1 Team',
                'team1_short' => 'R1',
                'team1_score' => null,
                'team2' => 'Rank #4 Team',
                'team2_short' => 'R4',
                'team2_score' => null,
                'match_date' => '2026-10-24',
                'match_time' => '09:30 AM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'UPCOMING',
                'result' => 'Winner qualifies for Grand Final',
                'order_position' => 5,
            ]);

            HomeFixture::create([
                'match_no' => 'MATCH 6',
                'stage' => 'GRAND FINAL',
                'team1' => 'Finalist 1',
                'team1_short' => 'F1',
                'team1_score' => null,
                'team2' => 'Finalist 2',
                'team2_short' => 'F2',
                'team2_score' => null,
                'match_date' => '2026-10-26',
                'match_time' => '02:00 PM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'UPCOMING',
                'result' => 'Championship Trophy Match & Prize Ceremony',
                'order_position' => 6,
            ]);
        }
    }
}