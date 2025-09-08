<?php

namespace App\Repositories;

use App\Models\BookingPassengers; // UBAH KE PLURAL

class BookingPassengersRepository
{
    protected $model;

    public function __construct(BookingPassengers $bookingPassengers) // UBAH KE PLURAL
    {
        $this->model = $bookingPassengers;
    }

    public function store(array $data): BookingPassengers
    {
        return BookingPassengers::create($data); // UBAH KE PLURAL
    }

    public function delete(BookingPassengers $passenger): bool // UBAH PARAMETER TYPE
    {
        return $passenger->delete();
    }
}