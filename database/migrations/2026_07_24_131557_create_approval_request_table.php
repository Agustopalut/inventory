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
        Schema::create('approval_request', function (Blueprint $table) {
            $table->id("id_request")->autoIncrement();
            $table->string('kd_transaksi_pending');
            $table->foreignId('user_id')->constrained('users');
            $table->string('modul');
            $table->date('tanggal_request');
            $table->string('aksi');
            $table->enum('status',['pending','approved','rejectd']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_request');
    }
};
