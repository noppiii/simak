<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DplsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dpls')->insert([
            'dpl_id' => "436573b1-12d1-4355-8270-ebea2bf64422",
            'user_id' => "d6e9fdfc-533e-49f8-ad9e-aa5a79282447",
            'prodi_id' => "b084843f-3642-4b43-89cf-445877a8f120",
            'nama' => 'Pak Kasrun',
            'nidn' => '9018290724',
            'telp' => '08981627371',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Desa Karang Baru Kecamatan Kepanjang Surabaya',
            'foto' => 'dpl.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}