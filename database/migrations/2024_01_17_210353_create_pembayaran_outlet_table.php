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
        Schema::create('pembayaran_outlet', function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->bigInteger('toko_id');
            $table->bigInteger('user_id');
            $table->string('nomor_pembayaran');
            $table->integer('lisensi_id');
            $table->integer('metode_pembayaran_id');
            $table->enum('status', ['transfer', 'no transfer', 'menunggu pengecekan']);
            $table->string('bukti_transfer');
            $table->text('keterangan');
            $table->timestamp('before');
            $table->timestamp('after');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_outlet');
    }
};
