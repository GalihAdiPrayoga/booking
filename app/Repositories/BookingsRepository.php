<?php

namespace App\Repositories;

use App\Models\Bookings;

class BookingsRepository
{
    public function get()
    {
        return Bookings::with('passengers')->get();
    }

    public function findById($id)
    {
        return Bookings::with('passengers')->findOrFail($id);
    }

    public function store(array $data)
    {
        return Bookings::store($data);
    }

    public function update(Bookings $bookings, array $data)
    {
        $bookings->update($data);
        return $bookings;
    }

    public function delete(Bookings $bookings)
    {
        return $bookings->delete();
    }
}
