<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PimpinanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pimpinans')->insert([
            'pimpinan_id' => "9beea5de-22b0-4734-a75d-627579ffebbf",
            'user_id' => "2ab30ae3-6a8b-4b7a-a50e-9b3db9ed1ac1",
            'nama' => 'Pak Junaidi',
            'telp' => '0818278712',
            'jenis_kelamin' => 'Laki-laki',
            'alamat' => 'Desa Karang Baru Kecamatan Kepanjang Surabaya',
            'foto' => 'pimpinan.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}