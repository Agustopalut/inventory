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
        Schema::create('barang_keluar_header_pending', function (Blueprint $table) {
            $table->string("kd_barang_keluar_pending")->primary();
            $table->date('tanggal_keluar');
            $table->foreignId('user_id')->constrained('users');
            $table->text('keterangan');
            $table->string('tujuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar_header_pending');
    }
};
