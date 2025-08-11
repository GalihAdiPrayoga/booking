<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('flights_classes')->insert([
            [
                'name' => 'ekonomi',
                'description' => 'Kelas penerbangan dasar dengan harga terjangkau',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'bisnis',
                'description' => 'Kelas dengan kenyamanan dan layanan lebih baik dari ekonomi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'first class',
                'description' => 'Kelas premium dengan layanan dan fasilitas terbaik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
