<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tickets')->insert([
            [
                'id' => 101,
                'flight_id' => 1,
                'class_id' => 1, // misal 1 = ekonomi
                'seat_number' => '1',
                'price' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 102,
                'flight_id' => 1,
                'class_id' => 1, // ekonomi
                'seat_number' => '2',
                'price' => 500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 103,
                'flight_id' => 2,
                'class_id' => 2, // bisnis
                'seat_number' => '3',
                'price' => 750000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
