<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('usv_members')) {
            $dataFile = database_path('seeders/members_data.php');
            if (file_exists($dataFile)) {
                $members = require $dataFile;
                foreach ($members as $member) {
                    DB::table('usv_members')->updateOrInsert(
                        ['sl_no' => $member['sl_no']],
                        [
                            'member_id' => $member['member_id'],
                            'name' => $member['name'],
                            'call_name' => $member['call_name'] ?? null,
                        ]
                    );
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down action needed
    }
};
