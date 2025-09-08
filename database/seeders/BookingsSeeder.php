<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bookings')->insert([
            [
                'id' => 1,
                'user_id' => 1, // pastikan user dengan id 1 ada
                'booking_date' => now(),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'booking_date' => now()->addDay(),
                'status' => 'confirmed',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
