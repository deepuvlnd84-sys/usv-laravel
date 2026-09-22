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
        if (!Schema::hasTable('usv_members')) {
            Schema::create('usv_members', function (Blueprint $table) {
                $table->integer('sl_no')->primary();
                $table->integer('member_id');
                $table->string('name', 150);
                $table->string('call_name', 100)->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usv_members');
    }
};
