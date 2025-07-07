<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\mekanik;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MekanikSeeder extends Seeder
{
	public function run(): void
	{
		$mekaniks = [
			[
				'name' => 'Nadya',
				'email' => 'nadya@gmail.com',
				'password' => 'password123',
				'kuantitas_hari' => 5,
			],
			[
				'name' => 'Willy',
				'email' => 'willy@gmail.com',
				'password' => 'password123',
				'kuantitas_hari' => 6,
			],
			[
				'name' => 'Mong',
				'email' => 'mong@gmail.com',
				'password' => 'password123',
				'kuantitas_hari' => 7,
			],
		];

		foreach ($mekaniks as $mekanikData) {
			// Check if mekanik user already exists
			$existingUser = User::where('email', $mekanikData['email'])->first();

			if ($existingUser) {
				$this->command->info("Mekanik user {$mekanikData['email']} already exists!");
				continue;
			}

			// Create User
			$user = User::create([
				'name' => $mekanikData['name'],
				'email' => $mekanikData['email'],
				'password' => Hash::make($mekanikData['password']),
				'role' => 'mekanik',
				'email_verified_at' => now(),
			]);

			// Create Mekanik record  
			Mekanik::create([
				'id' => $user->id, // Foreign key ke users table
				'kuantitas_hari' => $mekanikData['kuantitas_hari'],
			]);

			$this->command->info("Mekanik user {$mekanikData['name']} created successfully!");
		}
	}
}