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
        Schema::create('kkns', function (Blueprint $table) {
            $table->uuid('kkn_id')->primary();
            $table->string('nama');
            $table->string('status');
            $table->text('deskripsi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->date('tanggal_pendaftaran');
            $table->uuid('skema_id');
            $table->foreign('skema_id')->references('skema_id')->on('skemas')->onDelete('restrict');
            $table->uuid('desa_id');
            $table->foreign('desa_id')->references('desa_id')->on('desas')->onDelete('restrict');
            $table->uuid('periode_id');
            $table->foreign('periode_id')->references('periode_id')->on('periodes')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkns');
    }
};