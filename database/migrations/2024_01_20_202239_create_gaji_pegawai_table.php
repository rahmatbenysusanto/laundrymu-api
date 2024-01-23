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
        Schema::create('gaji_pegawai', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('toko_id');
            $table->bigInteger('pegawai_id');
            $table->decimal('gaji', 13, 0);
            $table->timestamp('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_pegawai');
    }
};
