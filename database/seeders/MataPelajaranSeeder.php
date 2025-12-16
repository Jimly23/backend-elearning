<?php

namespace Database\Seeders;

use App\Models\MataPelajaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MataPelajaran::create([
            'mata_pelajaran' => 'Algoritma dan Pemrograman',
        ]);
        MataPelajaran::create([
            'mata_pelajaran' => 'Sistem Operasi',
        ]);
        MataPelajaran::create([
            'mata_pelajaran' => 'Basis Data',
        ]);
    }
}
