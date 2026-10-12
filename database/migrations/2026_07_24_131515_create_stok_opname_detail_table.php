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
        Schema::create('stok_opname_detail', function (Blueprint $table) {
            $table->id("id_opname_detail")->autoIncrement();

            $table->unsignedBigInteger('id_barang');
            $table->foreign('id_barang')
            ->references('id_barang')
            ->on('barang_master');
            
            $table->unsignedInteger('stok_fisik');
            $table->unsignedInteger('stok_sistem');

            $table->string('kd_opname');
            $table->foreign('kd_opname')
            ->references('kd_opname')
            ->on('stok_opname_header');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_opname_detail');
    }
};
