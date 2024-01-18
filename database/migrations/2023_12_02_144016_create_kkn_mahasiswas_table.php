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
        Schema::create('kkn_mahasiswas', function (Blueprint $table) {
            $table->uuid('kkn_mhs_id')->primary();
            $table->string('nilai')->nullable();
            $table->uuid('mahasiswa_id');
            $table->foreign('mahasiswa_id')->references('mahasiswa_id')->on('mahasiswas')->onDelete('restrict');
            $table->uuid('dpl_id')->nullable();
            $table->foreign('dpl_id')->references('dpl_id')->on('dpls')->onDelete('restrict');
            $table->uuid('kkn_id');
            $table->foreign('kkn_id')->references('kkn_id')->on('kkns')->onDelete('restrict');
            $table->uuid('kelompok_id')->nullable();
            $table->foreign('kelompok_id')->references('kelompok_id')->on('kelompoks')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkn_mahasiswas');
    }
};