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
        Schema::create('inv_barang', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('outlet_id');
            $table->string('nama', 255);
            $table->integer('satuan_id');
            $table->integer('stock_minimum')->default(0);
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_barang');
    }
};
