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
            $table->string('president_photo_public_id')->nullable()->after('president_photo');
            $table->string('coordinator_photo_public_id')->nullable()->after('coordinator_photo');
        });

        Schema::table('contact_persons', function (Blueprint $table) {
            $table->string('photo_public_id')->nullable()->after('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn(['president_photo_public_id', 'coordinator_photo_public_id']);
        });

        Schema::table('contact_persons', function (Blueprint $table) {
            $table->dropColumn(['photo_public_id']);
        });
    }
};
