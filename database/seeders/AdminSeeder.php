<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@mechafix.com',
                'password' => 'password123',
                'shift_kerja' => 'Pagi',
                'gaji' => 8000000,
            ],
            [
                'name' => 'Admin Pagi',
                'email' => 'admin.pagi@mechafix.com',
                'password' => 'password123',
                'shift_kerja' => 'Pagi',
                'gaji' => 6500000,
            ],
            [
                'name' => 'Admin Sore',
                'email' => 'admin.sore@mechafix.com',
                'password' => 'password123',
                'shift_kerja' => 'Sore',
                'gaji' => 6500000,
            ],
            [
                'name' => 'Manager Admin',
                'email' => 'manager@mechafix.com',
                'password' => 'password123',
                'shift_kerja' => 'Pagi',
                'gaji' => 10000000,
            ],
        ];

        foreach ($admins as $adminData) {
            $existingUser = User::where('email', $adminData['email'])->first();

            if ($existingUser) {
                $this->command->info("Admin user {$adminData['email']} already exists!");
                continue;
            }

            $user = User::create([
                'name' => $adminData['name'],
                'email' => $adminData['email'],
                'password' => Hash::make($adminData['password']),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            Admin::create([
                'id' => $user->id,
                'shift_kerja' => $adminData['shift_kerja'],
                'gaji' => $adminData['gaji'],
            ]);

            $this->command->info("Admin user {$adminData['name']} created successfully!");
        }
    }
}
