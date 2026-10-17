<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('approval_request', function (Blueprint $table) {
            DB::statement("
            ALTER TABLE approval_request
            MODIFY status
            ENUM('pending', 'approved', 'rejected')
            NOT NULL
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('approval_request', function (Blueprint $table) {
            //
        });
    }
};
