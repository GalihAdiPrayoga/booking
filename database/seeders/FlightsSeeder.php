<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FlightsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('flights')->insert([
            [
                'airline' => 'Garuda Indonesia',
                'flight_number' => 'GA123',
                'origin_airport_id' => 1,
                'destination_airport_id' => 3,
                'departure_time' => Carbon::parse('2025-08-20 08:00:00'),
                'arrival_time' => Carbon::parse('2025-08-20 10:00:00'),
                'available_seats' => 150,
                'classes' => json_encode(['Economy', 'Business']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'airline' => 'Citilink',
                'flight_number' => 'QG456',
                'origin_airport_id' => 2,
                'destination_airport_id' => 3,
                'departure_time' => Carbon::parse('2025-08-21 13:00:00'),
                'arrival_time' => Carbon::parse('2025-08-21 15:30:00'),
                'available_seats' => 120,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
