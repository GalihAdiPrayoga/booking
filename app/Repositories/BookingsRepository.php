<?php

namespace App\Repositories;

use App\Models\bookings;

class BookingsRepository
{
    public function get()
    {
        return bookings::with('passengers')->get();
    }

    public function findById($id)
    {
        return bookings::with('passengers')->findOrFail($id);
    }

    public function store(array $data)
    {
        return bookings::create($data);
    }

    public function update(bookings $bookings, array $data)
    {
        $bookings->update($data);
        return $bookings;
    }

    public function delete(bookings $bookings)
    {
        return $bookings->delete();
    }
}
