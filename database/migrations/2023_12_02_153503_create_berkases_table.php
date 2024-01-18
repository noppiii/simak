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
        Schema::create('berkases', function (Blueprint $table) {
            $table->uuid('berkas_id')->primary();
            $table->string('file_berkas')->nullable();
            $table->string('link_berkas')->nullable();
            $table->string('status');
            $table->uuid('luaran_id');
            $table->foreign('luaran_id')->references('luaran_id')->on('luarans')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkases');
    }
};