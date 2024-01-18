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
        Schema::create('luarans', function (Blueprint $table) {
            $table->uuid('luaran_id')->primary();
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('nama_kegiatan');
            $table->date('tanggal_dimulai');
            $table->date('tanggal_diakhir');
            $table->uuid('kkn_mhs_id');
            $table->foreign('kkn_mhs_id')->references('kkn_mhs_id')->on('kkn_mahasiswas')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luarans');
    }
};
