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
        Schema::create('outlet_pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->bigInteger('outlet_id');
            $table->bigInteger('user_id');
            $table->integer('lisensi_id');
            $table->string('nomor_pembayaran');
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->string('url_payment')->nullable();
            $table->text('callback')->nullable();
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet_pembayaran');
    }
};
