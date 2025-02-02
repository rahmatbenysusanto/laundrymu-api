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
        Schema::create('inv_penggunaan_barang', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('outlet_id');
            $table->string('outbound_number');
            $table->string('jumlah'); // Jumlah Barang bukan jumlah QTY
            $table->integer('total_harga');
            $table->timestamp('tanggal_penggunaan');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_penggunaan_barang');
    }
};
