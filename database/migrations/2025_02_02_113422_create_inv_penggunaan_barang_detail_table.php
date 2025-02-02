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
        Schema::create('inv_penggunaan_barang_detail', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('penggunaan_barang_id');
            $table->integer('barang_id');
            $table->integer('inv_stock_detail');
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
        Schema::dropIfExists('inv_penggunaan_barang_detail');
    }
};
