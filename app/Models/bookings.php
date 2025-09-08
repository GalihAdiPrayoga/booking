<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bookings extends Model
{
    protected $table = 'bookings';
    
    protected $fillable = [
        'user_id', 
        'booking_date', 
        'status'
    ];

    public function passengers()
    {
        return $this->hasMany(BookingPassengers::class, 'booking_id', 'id');
    }
}