<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FakultasesTableSeeder::class);
        $this->call(ProdisTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(DplsTableSeeder::class);
        $this->call(PimpinanTableSeeder::class);
        $this->call(MahasiswasTableSeeder::class);

   }
}