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
        Schema::create('inv_pembelian_barang_detail', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('outlet_id');
            $table->integer('barang_id');
            $table->integer('qty');
            $table->integer('harga');
            $table->integer('total_harga');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_pembelian_barang_detail');
    }
};
