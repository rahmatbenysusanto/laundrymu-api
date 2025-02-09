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
        Schema::create('outlet_notification', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->integer('outlet_id');
            $table->boolean('nota')->default(false);
            $table->boolean('diproses')->default(false);
            $table->boolean('selesai')->default(false);
            $table->bigInteger('created_at')->nullable();
            $table->bigInteger('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet_notification');
    }
};
