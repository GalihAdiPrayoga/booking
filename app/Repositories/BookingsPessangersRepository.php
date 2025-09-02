<?php

namespace App\Repositories;

use App\Models\BookingPassenger;

class BookingPassengersRepository
{
    protected $model;

    public function __construct(BookingPassenger $bookingPassenger)
    {
        $this->model = $bookingPassenger;
    }

    public function store(array $data): BookingPassenger
    {
        return $this->model->create($data);
    }

    public function delete(BookingPassenger $passenger): bool
    {
        return $passenger->delete();
    }
}
