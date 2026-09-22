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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('president_name')->default('Deepu Vellanad');
            $table->string('president_role')->default('Club President');
            $table->string('president_phone')->default('+91 94470 12345');
            $table->string('president_photo')->nullable();
            $table->string('president_email')->nullable()->default('president@usv.com');

            $table->string('coordinator_name')->default('Sujith S.');
            $table->string('coordinator_role')->default('General Coordinator');
            $table->string('coordinator_phone')->default('+91 94470 67890');
            $table->string('coordinator_photo')->nullable();
            $table->string('coordinator_email')->nullable()->default('coordinator@usv.com');

            $table->string('facebook_url')->nullable()->default('https://facebook.com');
            $table->string('instagram_url')->nullable()->default('https://instagram.com');
            $table->string('youtube_url')->nullable()->default('https://youtube.com');
            $table->timestamps();
        });

        Schema::create('contact_persons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->string('phone');
            $table->string('photo')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Seed initial contact settings
        DB::table('contact_settings')->insert([
            'president_name' => 'Deepu Vellanad',
            'president_role' => 'Club President',
            'president_phone' => '+91 94470 12345',
            'president_photo' => null,
            'president_email' => 'president@usv.com',
            'coordinator_name' => 'Sujith S.',
            'coordinator_role' => 'General Coordinator',
            'coordinator_phone' => '+91 94470 67890',
            'coordinator_photo' => null,
            'coordinator_email' => 'coordinator@usv.com',
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'youtube_url' => 'https://youtube.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed initial 10 contact persons in grid style
        $initialPersons = [
            ['name' => 'Anil Kumar M.', 'designation' => 'Vice President', 'phone' => '+91 98471 11001', 'order' => 1],
            ['name' => 'Rahul R. Nair', 'designation' => 'General Secretary', 'phone' => '+91 98472 22002', 'order' => 2],
            ['name' => 'Vipin Das', 'designation' => 'Joint Secretary', 'phone' => '+91 98473 33003', 'order' => 3],
            ['name' => 'Arun Chandran', 'designation' => 'Treasurer', 'phone' => '+91 98474 44004', 'order' => 4],
            ['name' => 'Bipin B. S.', 'designation' => 'Team Captain', 'phone' => '+91 98475 55005', 'order' => 5],
            ['name' => 'Akhil S. Kumar', 'designation' => 'Vice Captain', 'phone' => '+91 98476 66006', 'order' => 6],
            ['name' => 'Renjith R.', 'designation' => 'Head Coach', 'phone' => '+91 98477 77007', 'order' => 7],
            ['name' => 'Midhun Mohan', 'designation' => 'Team Manager', 'phone' => '+91 98478 88008', 'order' => 8],
            ['name' => 'Sarath S.', 'designation' => 'Executive Member', 'phone' => '+91 98479 99009', 'order' => 9],
            ['name' => 'Vishnu Prasad', 'designation' => 'Executive Member', 'phone' => '+91 98470 00110', 'order' => 10],
        ];

        foreach ($initialPersons as $person) {
            DB::table('contact_persons')->insert([
                'name' => $person['name'],
                'designation' => $person['designation'],
                'phone' => $person['phone'],
                'photo' => null,
                'order' => $person['order'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_persons');
        Schema::dropIfExists('contact_settings');
    }
};
