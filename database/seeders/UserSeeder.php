<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::create([
            'nama' => 'Admin',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'Jl. Admin No. 1',
            'telepon' => '12345678',
            'foto_diri' => null,
            'role' => 'admin',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'nama' => 'Cleaning Service',
            'jenis_kelamin' => 'perempuan',
            'alamat' => 'Jl. CS No. 2',
            'telepon' => '1234567890',
            'foto_diri' => null,
            'role' => 'cleaning_service',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
    }
}
