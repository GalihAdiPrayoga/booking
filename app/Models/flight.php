<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FlightsClasses;
use App\Models\Tickets;

class Flight extends Model
{
    protected $table = "flights";

    protected $fillable = [
        'flight_number', 
        'origin_airport_id', 
        'destination_airport_id',
        'departure_time', 
        'arrival_time', 
        'available_seats'
    ];

    public function origin()
    {
        return $this->belongsTo(Airport::class, 'origin_airport_id');
    }

    public function destination()
    {
        return $this->belongsTo(Airport::class, 'destination_airport_id');
    }

    public function classes()
    {
        return $this->belongsToMany(FlightsClasses::class, 'flight_class', 'flight_id', 'flight_class_id')
                    ->withPivot('price', 'available_seats')
                    ->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
