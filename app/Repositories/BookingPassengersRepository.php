<?php

namespace App\Repositories;

use App\Models\BookingPassengers; 

class BookingPassengersRepository
{
    protected $model;

    public function __construct(BookingPassengers $bookingPassengers) 
    {
        $this->model = $bookingPassengers;
    }

    public function store(array $data): BookingPassengers
    {
        return BookingPassengers::create($data); 
    }

    public function delete(BookingPassengers $passenger): bool 
    {
        return $passenger->delete();
    }
}