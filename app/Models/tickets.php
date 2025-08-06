<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\bookings;
class tickets extends Model
{
    protected $fillable = ['flight_id', 'user_id', 'seat_number', 'class', 'price'];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->belongsToMany(bookings::class, 'booking_ticket');
    }
}
