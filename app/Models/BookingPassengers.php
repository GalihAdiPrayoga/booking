<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingPassengers extends Model
{
    protected $table = 'booking_passengers';
    
    protected $fillable = [
        'booking_id', 
        'ticket_id',
        'name',
        'identity_number'
    ];

    public function booking()
    {
        return $this->belongsTo(Bookings::class, 'booking_id', 'id');
    }
}