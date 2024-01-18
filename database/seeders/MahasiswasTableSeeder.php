<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswas')->insert([
            'mahasiswa_id' => "3b286ed9-cff8-4dc3-89b4-dbf09d173b56",
            'user_id' => "5ee1f340-73d6-49a3-8260-2ebd2581bb21",
            'prodi_id' => "b084843f-3642-4b43-89cf-445877a8f120",
            'nama' => 'Jospeh Iskandar',
            'nim' => '20016823613986',
            'telp' => '0819723329834',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Jalan Sepanjang Indah Blok IX Sidoarjo',
            'tanggal_lahir' => '2000-01-01',
            'foto' => 'mahasiswa.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}