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
            $table->string('club_email')->nullable()->default('unitedseniorsvellanadans@gmail.com');
            $table->string('club_phone')->nullable()->default('094478 89502');
            $table->string('ground_location')->nullable()->default('H345+JF, Vellanad, Keralam 695543');
            $table->text('ground_map_url')->nullable()->default('https://www.google.com/maps/place/Viswanathan+Memorial+Panchayath+Stadium,+Vellanad/@8.5565815,77.0396807,15z/data=!4m10!1m2!2m1!1sground+Vellanad!3m6!1s0x3b05b700298dfee1:0xce52ac8e1571f9d!8m2!3d8.5565815!4d77.0587351!15sCg9ncm91bmQgVmVsbGFuYWRaESIPZ3JvdW5kIHZlbGxhbmFkkgEKcGxheWdyb3VuZJoBRENpOURRVWxSUVVOdlpFTm9kSGxqUmpsdlQycGFRMU5FVmxwT2EyUklZbnBzTlZsWWFHWk5WR1F5V1c1T2JrNUlZeEFC4AEA-gEECAAQOw!16s%2Fg%2F11wqkkrh2d?entry=ttu&g_ep=EgoyMDI2MDkyMy4wIKXMDSoASAFQAw%3D%3D');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_settings', function (Blueprint $table) {
            $table->dropColumn(['club_email', 'club_phone', 'ground_location', 'ground_map_url']);
        });
    }
};
