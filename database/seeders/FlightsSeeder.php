<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Flight;
use Carbon\Carbon;

class FlightsSeeder extends Seeder
{
    public function run(): void
    {
       // 1. Garuda Indonesia
        $flight1 = Flight::create([
            'airline' => 'Garuda Indonesia',
            'flight_number' => 'GA123',
            'origin_airport_id' => 1,
            'destination_airport_id' => 3,
            'departure_time' => '2025-08-20 08:00:00',
            'arrival_time' => '2025-08-20 10:00:00',
            'available_seats' => 150,
        ]);
        $flight1->classes()->attach([
            1 => ['price' => 1500000, 'available_seats' => 100], // Ekonomi
            2 => ['price' => 3000000, 'available_seats' => 50],  // Bisnis
            3 => ['price' => 5000000, 'available_seats' => 20],  // First Class
        ]);

        // 2. Citilink
        $flight2 = Flight::create([
            'airline' => 'Citilink',
            'flight_number' => 'QG456',
            'origin_airport_id' => 2,
            'destination_airport_id' => 3,
            'departure_time' => '2025-08-21 13:00:00',
            'arrival_time' => '2025-08-21 15:30:00',
            'available_seats' => 120,
        ]);
        $flight2->classes()->attach([
            1 => ['price' => 1200000, 'available_seats' => 80],
            2 => ['price' => 2500000, 'available_seats' => 40],
            3 => ['price' => 5000000, 'available_seats' => 20], 
        ]);

        // 3. Batik Air
        $flight3 = Flight::create([
            'airline' => 'Batik Air',
            'flight_number' => 'ID789',
            'origin_airport_id' => 1,
            'destination_airport_id' => 2,
            'departure_time' => '2025-08-22 09:00:00',
            'arrival_time' => '2025-08-22 11:30:00',
            'available_seats' => 140,
        ]);
        $flight3->classes()->attach([
            1 => ['price' => 1400000, 'available_seats' => 90],
            2 => ['price' => 2800000, 'available_seats' => 50],
            3 => ['price' => 5000000, 'available_seats' => 20], 
        ]);
    }
}
