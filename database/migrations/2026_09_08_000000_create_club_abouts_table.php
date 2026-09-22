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
        Schema::create('club_abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('UNITED SENIORS VELLANAD');
            $table->string('tagline')->nullable()->default('Passion, Brotherhood & Cricket Spirit');
            $table->longText('description');
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->string('established_year')->nullable()->default('2018');
            $table->string('home_ground')->nullable()->default('Vellanad, Thiruvananthapuram, Kerala');
            $table->string('contact_email')->nullable()->default('deepuvlnd84@gmail.com');
            $table->string('contact_phone')->nullable()->default('+91 94470 00000');
            $table->timestamps();
        });

        // Seed initial default club about content
        DB::table('club_abouts')->insert([
            'title' => 'UNITED SENIORS VELLANAD',
            'tagline' => 'Passion, Brotherhood & Cricket Spirit',
            'description' => "United Seniors Vellanad (USV) is a premier cricket club rooted in the scenic heartlands of Vellanad, Thiruvananthapuram. Built on the bedrock of genuine sportsmanship, athletic dedication, and lifelong camaraderie, USV unites seasoned cricketers and enthusiastic players across generations under a common banner of passion for the gentleman's game.\n\nSince our inception, United Seniors Vellanad has actively competed in regional tournaments, club fixtures, and invitational championships. Beyond runs and wickets, our club represents an enduring brotherhood that celebrates community bonding, healthy active lifestyles, and mentorship for young budding cricketers.\n\nWhether on the pitch chasing victory or off the pitch organizing local sports initiatives, USV continues to carry forward the timeless spirit and joy of cricket in Vellanad.",
            'mission' => 'To promote cricket and sporting excellence in Vellanad, nurturing athletic talent, teamwork, and healthy living across all age groups while upholding the highest ideals of fair play and sportsmanship.',
            'vision' => 'To be a distinguished and inspiring community sports organization renowned for cricket achievement, youth development, and enduring brotherhood.',
            'established_year' => '2018',
            'home_ground' => 'Vellanad Ground, Thiruvananthapuram, Kerala',
            'contact_email' => 'deepuvlnd84@gmail.com',
            'contact_phone' => '+91 94470 00000',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_abouts');
    }
};
