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
        Schema::create('barang_masuk_pending', function (Blueprint $table) {
            $table->string("kd_barang_masuk_pending")->primary();

            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')
            ->references('id_barang')
            ->on('barang_master');
            
            $table->unsignedInteger('jumlah');
            $table->unsignedInteger('sisa')->default(0);
            $table->unsignedInteger('harga_satuan');
            $table->date('tanggal_masuk')->nullable();
            $table->foreignId('user_id')->constrained('users');
            // $table->foreignId('kd_barang_masuk')->constrained('barang_masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuk_pending');
    }
};
