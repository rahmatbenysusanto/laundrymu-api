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
        Schema::create('outlet', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->bigInteger('user_id');
            $table->string('nama', 255);
            $table->string('no_hp', 20)->nullable();
            $table->string('logo', 255);
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamp('expired');
            $table->text('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->integer('kode_pos')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outlet');
    }
};
