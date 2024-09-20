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
        Schema::create('transaksi_has_outlet', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->bigInteger('outlet_id');
            $table->integer('jumlah_transaksi');
            $table->decimal('nominal_transaksi', 13, 0);
            $table->timestamp('waktu');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_has_outlet');
    }
};
