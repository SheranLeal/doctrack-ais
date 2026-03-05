<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'AIS Administrator',
            'email' => 'admin@ais.edu.ph',
            'password' => Hash::make('Admin@2025'),
            'role' => 'admin',
            'department' => 'Administration',
            'position' => 'System Administrator',
        ]);
    }
}