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
        Schema::create('important_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('message');
            $table->string('badge')->default('ANNOUNCEMENT');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert initial sample important messages
        DB::table('important_messages')->insert([
            [
                'title' => 'USV Premier League 2026 Registrations Open!',
                'message' => 'All senior players and members are requested to register before 10th October 2026. Online registration portal is live.',
                'badge' => 'URGENT',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Annual General Body Meeting Notice',
                'message' => 'The Annual General Body meeting of United Seniors Vellanad will be held on Sunday at 5:00 PM at Vellanad Club House.',
                'badge' => 'NOTICE',
                'is_active' => true,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'title' => 'Ground Practice Session Timings',
                'message' => 'Weekend practice sessions will commence from 6:30 AM every Saturday & Sunday at Vellanad Stadium.',
                'badge' => 'UPDATE',
                'is_active' => true,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('important_messages');
    }
};
