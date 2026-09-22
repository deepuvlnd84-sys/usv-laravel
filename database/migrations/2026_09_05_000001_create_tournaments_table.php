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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('edition')->nullable();
            $table->string('venue')->nullable();
            $table->date('start_date')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('Upcoming'); // Upcoming, Ongoing, Completed
            $table->string('trophy_image')->nullable();
            $table->timestamps();
        });

        // Pre-seed the existing three signature tournaments
        DB::table('tournaments')->insert([
            [
                'name' => 'Premier League',
                'edition' => 'Season 2026',
                'venue' => 'Vellanad Stadium',
                'start_date' => '2026-10-15',
                'description' => 'The premier cricket league tournament of United Seniors Vellanad.',
                'status' => 'Upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Champions League',
                'edition' => 'Annual Trophy',
                'venue' => 'USV Sports Complex',
                'start_date' => '2026-11-20',
                'description' => 'Battle of champions across top senior squads.',
                'status' => 'Upcoming',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Discovery League',
                'edition' => 'Talent Series',
                'venue' => 'Vellanad Central Ground',
                'start_date' => '2026-12-05',
                'description' => 'Showcase of rising talents and senior stars.',
                'status' => 'Upcoming',
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
        Schema::dropIfExists('tournaments');
    }
};
