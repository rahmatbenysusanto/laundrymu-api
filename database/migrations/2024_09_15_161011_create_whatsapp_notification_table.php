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
        Schema::create('whatsapp_notification', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('no_hp');
            $table->text('message');
            $table->enum('status', ['failed', 'success']);
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_notification');
    }
};
