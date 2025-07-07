<?php

namespace Database\Seeders;

use App\Models\Mekanik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MekanikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mekanik::create(['nama_mekanik' => 'William Saputra', 'kuantitas_hari' => 0]);
        Mekanik::create(['nama_mekanik' => 'Pramajaya', 'kuantitas_hari' => 0]);
    }
}
