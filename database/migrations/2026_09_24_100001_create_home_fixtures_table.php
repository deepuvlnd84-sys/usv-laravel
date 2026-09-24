<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('home_fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('match_no')->default('1');
            $table->string('stage')->default('Group Stage');
            $table->string('team1');
            $table->string('team1_short')->nullable();
            $table->string('team1_score')->nullable();
            $table->string('team2');
            $table->string('team2_short')->nullable();
            $table->string('team2_score')->nullable();
            $table->string('match_date');
            $table->string('match_time');
            $table->string('venue')->default('Vellanad Stadium');
            $table->string('status')->default('Upcoming'); // Upcoming, Ongoing, Completed
            $table->string('result')->nullable();
            $table->integer('order_position')->default(0);
            $table->timestamps();
        });

        // Insert initial 6 fixtures matches
        DB::table('home_fixtures')->insert([
            [
                'match_no' => 'Match 1',
                'stage' => 'Group Stage • Match 1',
                'team1' => 'Vellanad Strikers',
                'team1_short' => 'VS',
                'team1_score' => '168/6 (20.0)',
                'team2' => 'USV Royals',
                'team2_short' => 'UR',
                'team2_score' => '162/9 (20.0)',
                'match_date' => '15 Oct 2026',
                'match_time' => '09:00 AM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'Completed',
                'result' => 'Vellanad Strikers won by 6 runs',
                'order_position' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'match_no' => 'Match 2',
                'stage' => 'Group Stage • Match 2',
                'team1' => 'Vellanad Warriors',
                'team1_short' => 'VW',
                'team1_score' => '155/7 (20.0)',
                'team2' => 'USV Titans',
                'team2_short' => 'UT',
                'team2_score' => '156/4 (18.4)',
                'match_date' => '16 Oct 2026',
                'match_time' => '02:00 PM IST',
                'venue' => 'Vellanad Central Ground',
                'status' => 'Completed',
                'result' => 'USV Titans won by 6 wickets',
                'order_position' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'match_no' => 'Match 3',
                'stage' => 'Group Stage • Match 3',
                'team1' => 'Vellanad Strikers',
                'team1_short' => 'VS',
                'team1_score' => '182/4 (20.0)',
                'team2' => 'USV Titans',
                'team2_short' => 'UT',
                'team2_score' => '134/8 (15.2)',
                'match_date' => '18 Oct 2026',
                'match_time' => '09:30 AM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'Ongoing',
                'result' => 'USV Titans need 49 runs in 28 balls',
                'order_position' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'match_no' => 'Match 4',
                'stage' => 'Group Stage • Match 4',
                'team1' => 'USV Royals',
                'team1_short' => 'UR',
                'team1_score' => null,
                'team2' => 'Vellanad Warriors',
                'team2_short' => 'VW',
                'team2_score' => null,
                'match_date' => '20 Oct 2026',
                'match_time' => '02:00 PM IST',
                'venue' => 'Vellanad Sports Complex',
                'status' => 'Upcoming',
                'result' => 'Toss at 01:30 PM IST',
                'order_position' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'match_no' => 'Match 5',
                'stage' => 'Semi Final 1',
                'team1' => 'Rank #1 Team',
                'team1_short' => 'TBD',
                'team1_score' => null,
                'team2' => 'Rank #4 Team',
                'team2_short' => 'TBD',
                'team2_score' => null,
                'match_date' => '24 Oct 2026',
                'match_time' => '09:30 AM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'Upcoming',
                'result' => 'Winner qualifies for Grand Final',
                'order_position' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'match_no' => 'Match 6',
                'stage' => 'Grand Final',
                'team1' => 'Finalist 1',
                'team1_short' => 'TBD',
                'team1_score' => null,
                'team2' => 'Finalist 2',
                'team2_short' => 'TBD',
                'team2_score' => null,
                'match_date' => '26 Oct 2026',
                'match_time' => '02:00 PM IST',
                'venue' => 'Vellanad Main Stadium',
                'status' => 'Upcoming',
                'result' => 'Championship Trophy Match & Prize Ceremony',
                'order_position' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_fixtures');
    }
};
