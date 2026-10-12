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
        Schema::create('barang_master', function (Blueprint $table) {
            $table->id("id_barang")->autoIncrement();
            $table->string("nama_barang");
            $table->decimal("stok",10,2)->default(0);
            $table->string('satuan');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_master');
    }
};
