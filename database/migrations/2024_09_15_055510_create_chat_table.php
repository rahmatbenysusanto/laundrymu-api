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
        Schema::create('chat', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->bigInteger('outlet_id');
            $table->enum('role', ['admin', 'client']);
            $table->text('chat');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
