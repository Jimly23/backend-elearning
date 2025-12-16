<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Siswa',
            'email' => 'student@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
    }
}
