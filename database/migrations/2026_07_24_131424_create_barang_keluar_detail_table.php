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
        Schema::create('barang_keluar_detail', function (Blueprint $table) {
            $table->id("id_detail")->autoIncrement()->primary();

            $table->string('kd_barang_keluar');
            $table->foreign("kd_barang_keluar")
            ->references('kd_barang_keluar')
            ->on('barang_keluar_header');

            $table->string('kd_barang_masuk');
            $table->foreign("kd_barang_masuk")
            ->references('kd_barang_masuk')
            ->on('barang_masuk');

            $table->decimal('jumlah_yang_diambil',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_keluar_detail');
    }
};
