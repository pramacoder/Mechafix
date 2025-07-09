<?php

namespace Database\Seeders;

use App\Models\Mekanik;
use App\Models\Service;
use App\Models\SparePart;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        AdminSeeder::class;
        HariLiburSeeder::class;
        MekanikSeeder::class;
        ServiceSeeder::class;
        SparePartSeeder::class;
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
