<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SparePart;

class SparePartSeeder extends Seeder
{
    public function run(): void
    {
        $spareParts = [
            // Spare Parts Umum Motor
            [
                'nama_barang' => 'Oli Mesin Shell Helix HX3 10W-40',
                'deskripsi_barang' => 'Oli mesin motor 4 tak berkualitas tinggi dengan viskositas 10W-40. Cocok untuk semua jenis motor bebek dan matik.',
                'harga_barang' => 35000,
                'kuantitas_barang' => 50,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Filter Udara KTC Universal',
                'deskripsi_barang' => 'Filter udara aftermarket berkualitas tinggi untuk motor bebek Honda, Yamaha, dan Suzuki. Material berkualitas dengan daya saring optimal.',
                'harga_barang' => 25000,
                'kuantitas_barang' => 30,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Kampas Rem Depan Indopart',
                'deskripsi_barang' => 'Kampas rem depan original Indopart untuk motor bebek dan matik. Daya cengkeram kuat dan tahan lama.',
                'harga_barang' => 45000,
                'kuantitas_barang' => 25,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Kampas Rem Belakang Indopart',
                'deskripsi_barang' => 'Kampas rem belakang berkualitas untuk motor bebek dan matik. Memberikan pengereman yang responsif dan aman.',
                'harga_barang' => 35000,
                'kuantitas_barang' => 25,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Busi NGK C7HSA',
                'deskripsi_barang' => 'Busi NGK original untuk motor bebek 110-125cc. Memberikan pembakaran sempurna dan performa mesin optimal.',
                'harga_barang' => 15000,
                'kuantitas_barang' => 100,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Busi NGK CPR8E',
                'deskripsi_barang' => 'Busi NGK khusus motor matik 110-150cc. Teknologi iridium untuk performa maksimal dan hemat bahan bakar.',
                'harga_barang' => 18000,
                'kuantitas_barang' => 80,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Rantai Motor SSS 415',
                'deskripsi_barang' => 'Rantai motor premium SSS ukuran 415 untuk bebek. Material baja berkualitas tinggi, tahan lama dan minim perawatan.',
                'harga_barang' => 85000,
                'kuantitas_barang' => 15,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Gear Set Depan KTC',
                'deskripsi_barang' => 'Sproket depan aftermarket berkualitas tinggi. Presisi tinggi dan tahan aus untuk performa transmisi optimal.',
                'harga_barang' => 35000,
                'kuantitas_barang' => 20,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Gear Set Belakang KTC',
                'deskripsi_barang' => 'Sproket belakang precision cut dengan material baja berkualitas. Cocok untuk berbagai jenis motor bebek.',
                'harga_barang' => 45000,
                'kuantitas_barang' => 20,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Bearing Roda Depan NTN',
                'deskripsi_barang' => 'Bearing roda depan original NTN Jepang. Presisi tinggi, kedap air, dan tahan lama untuk putaran roda yang halus.',
                'harga_barang' => 25000,
                'kuantitas_barang' => 40,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Bearing Roda Belakang NTN',
                'deskripsi_barang' => 'Bearing roda belakang berkualitas Jepang. Sealed bearing tahan air dan debu, untuk performa jangka panjang.',
                'harga_barang' => 30000,
                'kuantitas_barang' => 35,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'V-Belt Aspira Motor Matik',
                'deskripsi_barang' => 'V-belt premium untuk motor matik 110-150cc. Material rubber compound berkualitas tinggi, tahan panas dan aus.',
                'harga_barang' => 75000,
                'kuantitas_barang' => 18,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Roller CVT Aspira Set',
                'deskripsi_barang' => 'Set roller CVT 6 pcs untuk motor matik. Berat standar, material berkualitas untuk transmisi CVT yang smooth.',
                'harga_barang' => 45000,
                'kuantitas_barang' => 22,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Per Kopling Motor Matik Indopart',
                'deskripsi_barang' => 'Per kopling sentrifugal untuk transmisi motor matik. Spring tension optimal untuk engagement yang responsif.',
                'harga_barang' => 35000,
                'kuantitas_barang' => 25,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Ban Dalam IRC 70/90-17',
                'deskripsi_barang' => 'Ban dalam IRC Jepang ukuran 70/90-17 untuk motor bebek. Material butyl rubber berkualitas tinggi, tahan bocor.',
                'harga_barang' => 20000,
                'kuantitas_barang' => 30,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Ban Dalam IRC 80/90-14',
                'deskripsi_barang' => 'Ban dalam IRC untuk motor matik ukuran 80/90-14. Kualitas Jepang dengan daya tahan tinggi terhadap panas.',
                'harga_barang' => 18000,
                'kuantitas_barang' => 30,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Kabel Gas Indopart Universal',
                'deskripsi_barang' => 'Kabel gas aftermarket berkualitas dengan inner cable stainless steel. Operasi throttle yang smooth dan responsif.',
                'harga_barang' => 25000,
                'kuantitas_barang' => 35,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Kabel Rem Depan Indopart',
                'deskripsi_barang' => 'Kabel rem tangan depan dengan inner cable berkualitas. Memberikan pengereman yang presisi dan aman.',
                'harga_barang' => 20000,
                'kuantitas_barang' => 40,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Kabel Speedometer KTC',
                'deskripsi_barang' => 'Kabel speedometer universal dengan core cable fleksibel. Transmisi putaran yang akurat untuk pembacaan kecepatan.',
                'harga_barang' => 30000,
                'kuantitas_barang' => 25,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Bohlam Lampu Depan Osram H4',
                'deskripsi_barang' => 'Bohlam lampu depan Osram H4 12V 35/35W. Teknologi halogen untuk penerangan optimal dan tahan lama.',
                'harga_barang' => 35000,
                'kuantitas_barang' => 45,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Anting Shock Depan Aspira',
                'deskripsi_barang' => 'Shock absorber depan aftermarket Aspira. Teknologi hydraulic untuk kenyamanan berkendara yang optimal.',
                'harga_barang' => 120000,
                'kuantitas_barang' => 12,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Shock Belakang KTC Twin',
                'deskripsi_barang' => 'Shock absorber belakang twin tube dengan adjustable preload. Material berkualitas tinggi untuk performa maksimal.',
                'harga_barang' => 180000,
                'kuantitas_barang' => 10,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'CDI Racing Shogun 125',
                'deskripsi_barang' => 'CDI racing untuk Suzuki Shogun 125. Pengapian yang lebih responsif untuk performa mesin yang maksimal.',
                'harga_barang' => 85000,
                'kuantitas_barang' => 8,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Karburator PE28 Universal',
                'deskripsi_barang' => 'Karburator racing PE28 untuk upgrade performa motor bebek. Venturi 28mm untuk suplai bahan bakar optimal.',
                'harga_barang' => 250000,
                'kuantitas_barang' => 6,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ],
            [
                'nama_barang' => 'Koil Racing TCI Universal',
                'deskripsi_barang' => 'Koil pengapian racing untuk motor TCI. Output tegangan tinggi untuk pembakaran sempurna dan tenaga maksimal.',
                'harga_barang' => 65000,
                'kuantitas_barang' => 15,
                'gambar_barang' => 'oli motor.webp',
                'link_shopee' => 'https://shopee.co.id'
            ]
        ];

        foreach ($spareParts as $part) {
            SparePart::create($part);
        }
    }
}