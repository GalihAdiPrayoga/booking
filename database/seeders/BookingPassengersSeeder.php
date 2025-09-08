<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingPassengersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('booking_passengers')->insert([
            [
                'booking_id' => 1,
                'ticket_id' => 101,
                'name' => 'John Doe',
                'identity_number' => 'ID1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'booking_id' => 1,
                'ticket_id' => 102,
                'name' => 'Jane Doe',
                'identity_number' => 'ID0987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
