<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bookings;
use App\Models\Flight;
use App\Models\User;

class Tickets extends Model
{
    protected $table = 'tickets';

    protected $fillable = [
        'flight_id',
        'class_id',
        'price',
        'seat_number',
    ];

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
        return $this->belongsToMany(Bookings::class, 'booking_ticket', 'ticket_id', 'booking_id');
    }
}
