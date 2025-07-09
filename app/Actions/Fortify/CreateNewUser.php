<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Konsumen;
use App\Models\Mekanik;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        // Base validation rules
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];

        // Role validation - allow admin only in local environment
        $allowedRoles = ['konsumen', 'mekanik'];
        if (app()->environment('local')) {
            $allowedRoles[] = 'admin';
        }
        $rules['role'] = ['required', 'in:' . implode(',', $allowedRoles)];

        // Add conditional validation based on role
        if (isset($input['role'])) {
            if ($input['role'] === 'konsumen') {
                $rules['alamat_konsumen'] = ['required', 'string', 'max:255'];
            } elseif ($input['role'] === 'mekanik') {
                $rules['kuantitas_hari'] = ['required', 'integer', 'in:5,6,7'];
            } elseif ($input['role'] === 'admin') {
                $rules['shift_kerja'] = ['required', 'in:Pagi,Sore'];
                $rules['gaji'] = ['required', 'integer', 'min:1000000', 'max:50000000'];
            }
        }

        Validator::make($input, $rules)->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'role' => $input['role'],
            'password' => Hash::make($input['password']),
            'alamat_konsumen' => ['required_if:role,konsumen'],
            'kuantitas_hari' => ['required_if:role,mekanik'],
        ]);

        // Create related records based on role
        if ($user->role === 'konsumen') {
            Konsumen::create([
                'id' => $user->id,
                'alamat_konsumen' => $input['alamat_konsumen'],
            ]);
        } elseif ($user->role === 'mekanik') {
            Mekanik::create([
                'id' => $user->id,
                'kuantitas_hari' => $input['kuantitas_hari'],
            ]);
        } elseif ($user->role === 'admin') {
            Admin::create([
                'id' => $user->id,
                'shift_kerja' => $input['shift_kerja'],
                'gaji' => $input['gaji'],
            ]);
        }

        return $user;
    }
}
