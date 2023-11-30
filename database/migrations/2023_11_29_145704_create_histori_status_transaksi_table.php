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
        Schema::create('histori_status_transaksi', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('transaksi_id');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'diambil']);
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_status_transaksi');
    }
};
