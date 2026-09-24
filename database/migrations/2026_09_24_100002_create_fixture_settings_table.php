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
        Schema::create('fixture_settings', function (Blueprint $table) {
            $table->id();
            $table->string('pdf_filename')->nullable();
            $table->string('pdf_title')->default('FULL FIXTURES');
            $table->timestamps();
        });

        // Seed initial row
        DB::table('fixture_settings')->insert([
            'pdf_filename' => null,
            'pdf_title' => 'FULL FIXTURES',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_settings');
    }
};
