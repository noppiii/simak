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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->uuid('mahasiswa_id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->uuid('prodi_id');
            $table->foreign('prodi_id')->references('prodi_id')->on('prodis')->onDelete('cascade');
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('telp');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->date('tanggal_lahir');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};