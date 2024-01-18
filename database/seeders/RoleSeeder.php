<?php

namespace Database\Seeders;

use App\Models\RoleModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            'role_id' => "5c7d5916-aaa6-4d9b-a90b-95e923e8eccb",
            'role_name' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'role_id' => "fe8090d9-26f5-4411-824e-29208354b238",
            'role_name' => 'Dosen',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'role_id' => "c8466b6f-5e5b-4d73-8b92-897f9d5166dc",
            'role_name' => 'Pimpinan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'role_id' => "c288bbc3-0f3d-427f-ac9c-0488377e4a50",
            'role_name' => 'Mahasiswa',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            'role_id' => "10dff1d9-e279-4024-88fa-fcd8b0ec8f25",
            'role_name' => 'Staff',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}