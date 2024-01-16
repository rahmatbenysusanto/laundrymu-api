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
        Schema::create('pelanggan_has_transaksi', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('pelanggan_id');
            $table->bigInteger('jumlah_transaksi');
            $table->bigInteger('jumlah_transaksi_bulanan');
            $table->decimal('nominal_transaksi', 13, 0);
            $table->decimal('nominal_transaksi_bulanan', 13, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan_has_transaksi');
    }
};
