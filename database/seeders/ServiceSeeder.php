<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Service Rutin
            [
                'nama_service' => 'Ganti Oli Mesin',
                'jenis_service' => 'Service Rutin',
                'biaya_service' => 50000,
                'estimasi_waktu' => 30,
            ],
            [
                'nama_service' => 'Ganti Filter Udara',
                'jenis_service' => 'Service Rutin',
                'biaya_service' => 25000,
                'estimasi_waktu' => 15,
            ],
            [
                'nama_service' => 'Pembersihan Karburator',
                'jenis_service' => 'Service Rutin',
                'biaya_service' => 75000,
                'estimasi_waktu' => 45,
            ],
            [
                'nama_service' => 'Pengecekan Rem',
                'jenis_service' => 'Service Rutin',
                'biaya_service' => 30000,
                'estimasi_waktu' => 20,
            ],
            [
                'nama_service' => 'Tune Up Ringan',
                'jenis_service' => 'Service Rutin',
                'biaya_service' => 100000,
                'estimasi_waktu' => 60,
            ],
            
            // Service Berat
            [
                'nama_service' => 'Overhaul Mesin',
                'jenis_service' => 'Service Berat',
                'biaya_service' => 800000,
                'estimasi_waktu' => 480,
            ],
            [
                'nama_service' => 'Ganti Kampas Rem',
                'jenis_service' => 'Service Berat',
                'biaya_service' => 150000,
                'estimasi_waktu' => 90,
            ],
            [
                'nama_service' => 'Ganti Rantai & Gear',
                'jenis_service' => 'Service Berat',
                'biaya_service' => 200000,
                'estimasi_waktu' => 120,
            ],
            [
                'nama_service' => 'Perbaikan Kopling',
                'jenis_service' => 'Service Berat',
                'biaya_service' => 300000,
                'estimasi_waktu' => 180,
            ],
            [
                'nama_service' => 'Ganti Piston & Ring',
                'jenis_service' => 'Service Berat',
                'biaya_service' => 500000,
                'estimasi_waktu' => 300,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}