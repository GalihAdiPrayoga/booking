<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('airports')->insert([
            [
                'name' => 'Soekarno-Hatta International Airport',
                'code' => 'CGK',
                'city' => 'Jakarta',
                'country' => 'Indonesia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ngurah Rai International Airport',
                'code' => 'DPS',
                'city' => 'Denpasar',
                'country' => 'Indonesia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Juanda International Airport',
                'code' => 'SUB',
                'city' => 'Surabaya',
                'country' => 'Indonesia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
