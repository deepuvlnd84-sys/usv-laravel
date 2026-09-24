<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('register_details')) {
            Schema::create('register_details', function (Blueprint $table) {
                $table->id();
                $table->string('photo')->nullable();
                
                // Section 1: Basic Details
                $table->string('name', 150);
                $table->string('mobile_no', 30);
                $table->text('address')->nullable();
                $table->integer('age')->nullable();
                $table->date('dob')->nullable();
                $table->string('blood_group', 10)->nullable();
                $table->string('education_qualification', 150)->nullable();
                $table->string('job', 150)->nullable();
                $table->text('remarks')->nullable();

                // Section 2: Player Details
                $table->string('playing_role', 50); // Batsman, Bowler, Allrounder, Wicket Keeper Batsman
                $table->string('batting_style', 50)->nullable(); // Right hand, Left hand
                $table->string('bowling_arm', 50)->nullable(); // Right arm, Left arm
                $table->string('bowling_pace', 50)->nullable(); // Pace, Medium, Slow
                $table->string('wicket_keeping_style', 100)->nullable();
                $table->string('batting_position', 50)->nullable(); // Top Order, Middle Order, Lower Order
                $table->string('jersey_number', 10)->nullable();
                $table->string('previous_clubs', 255)->nullable();
                $table->string('cricket_experience', 255)->nullable();

                // Admin lock feature
                $table->boolean('is_locked')->default(false);

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_details');
    }
};
