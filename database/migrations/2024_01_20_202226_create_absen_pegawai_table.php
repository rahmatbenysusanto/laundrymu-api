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
        Schema::create('absen_pegawai', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('toko_id');
            $table->bigInteger('pegawai_id');
            $table->enum('status', ['masuk', 'tidak masuk', 'izin', 'libur', 'tanggal merah']);
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absen_pegawai');
    }
};
