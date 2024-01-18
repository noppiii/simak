<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'admin_id' => "083ecc55-de33-4518-be2e-3ec69cc25bae",
            'user_id' => "0495af3e-deda-4780-9793-aea1011c5d16",
            'nama' => 'Super Admin',
            'telp' => '12345',
            'foto' => 'admin.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}