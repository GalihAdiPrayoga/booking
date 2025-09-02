<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPassenger extends Model
{
    protected $fillable = ['booking_id', 'name', 'identity_number', 'seat_number'];

    public function bookings() 
    {
        return $this->belongsTo(bookings::class);
    }
}
