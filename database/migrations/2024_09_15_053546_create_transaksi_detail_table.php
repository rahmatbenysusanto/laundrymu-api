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
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->bigInteger('transaksi_id');
            $table->bigInteger('layanan_id');
            $table->bigInteger('parfum_id');
            $table->integer('jumlah');
            $table->decimal('harga', 13, 0);
            $table->decimal('total_harga', 13, 0);
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
