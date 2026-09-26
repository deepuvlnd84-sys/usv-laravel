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
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->text('president_photo')->nullable()->change();
            $table->text('coordinator_photo')->nullable()->change();
            $table->text('facebook_url')->nullable()->change();
            $table->text('instagram_url')->nullable()->change();
            $table->text('youtube_url')->nullable()->change();
        });

        Schema::table('contact_persons', function (Blueprint $table) {
            $table->text('photo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
