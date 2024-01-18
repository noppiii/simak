<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'user_id' => "d6e9fdfc-533e-49f8-ad9e-aa5a79282447",
            'role_id' => "fe8090d9-26f5-4411-824e-29208354b238",
            'email' => 'dosen@dosen.com',
            'password' => Hash::make('12345'),
            // 'login_time' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => "5ee1f340-73d6-49a3-8260-2ebd2581bb21",
            'role_id' => "c288bbc3-0f3d-427f-ac9c-0488377e4a50",
            'email' => 'mahasiswa@mahasiswa.com',
            'password' => Hash::make('12345'),
            // 'login_time' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => "2ab30ae3-6a8b-4b7a-a50e-9b3db9ed1ac1",
            'role_id' => "c8466b6f-5e5b-4d73-8b92-897f9d5166dc",
            'email' => 'pimpinan@pimpinan.com',
            'password' => Hash::make('12345'),
            // 'login_time' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'user_id' => "0495af3e-deda-4780-9793-aea1011c5d16",
            'role_id' => "5c7d5916-aaa6-4d9b-a90b-95e923e8eccb",
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345'),
            // 'login_time' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}