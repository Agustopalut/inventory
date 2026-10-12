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
        Schema::create('production_request_detail', function (Blueprint $table) {
            $table->id("id_detail_production_request")->autoIncrement();

            $table->string('kd_production_request');
            $table->foreign("kd_production_request")
            ->references('kd_production_request')
            ->on('production_request_header');

            $table->unsignedBigInteger('id_barang');
            $table->foreign("id_barang")
            ->references('id_barang')
            ->on('barang_master');

            $table->unsignedInteger('jumlah_yang_diminta');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_request_detail');
    }
};
