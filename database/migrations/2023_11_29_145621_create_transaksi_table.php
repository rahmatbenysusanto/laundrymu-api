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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('toko_id');
            $table->bigInteger('pelanggan_id');
            $table->bigInteger('diskon_id');
            $table->bigInteger('pengiriman_id');
            $table->bigInteger('pembayaran_id');
            $table->string('order_number');
            $table->enum('status', ['baru', 'diproses', 'selesai', 'diambil']);
            $table->enum('status_pembayaran', ['lunas', 'belum lunas']);
            $table->decimal('harga', 13, 0);
            $table->decimal('harga_diskon', 13, 0);
            $table->decimal('total_harga', 13, 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
