<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parfum', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->bigInteger('outlet_id');
            $table->string('nama', 100);
            $table->decimal('harga', 13, 0);
            $table->boolean('delete')->default(0);
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parfum');
    }
};
