<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\tickets;

class flight extends Model
{
    protected $table = "flights";
  protected $fillable = [
        'flight_number', 'origin_airport_id', 'destination_airport_id',
        'departure_time', 'arrival_time', 'price', 'available_seats'
    ];

    public function origin()
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destination()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }

    public function tickets()
    {
        return $this->hasMany(tickets::class);
    }
}
