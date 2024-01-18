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
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->uuid('sertifikat_id')->primary();
            $table->string('file_sertifikat');
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
        Schema::dropIfExists('sertifikats');

  }
};