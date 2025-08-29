<?php

namespace App\Repositories;

use App\Models\Bookings;

class BookingsRepository
{
    public function get()
    {
        return Bookings::all();
    }

    public function store(array $data): Bookings
    {
        return Bookings::create($data);
    }

    public function find(int $id): ?Bookings
    {
        return Bookings::find($id);
    }

    public function update(Bookings $bookings, array $data): bool
    {
        return $bookings->update($data);
    }

    public function delete(Bookings $bookings): bool
    {
        return $bookings->delete();
    }
}
