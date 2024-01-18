<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FakultasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fakultases')->insert([
            'fakultas_id' => "5599845a-6877-4f84-9c92-eb939b592d3d",
            'nama' => 'Ilmu Komputer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}