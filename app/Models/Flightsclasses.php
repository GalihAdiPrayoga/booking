<?php

namespace App\Models;
use App\Models\Flight;
use App\Models\Tickets;
use Illuminate\Database\Eloquent\Model;

class FlightsClasses extends Model
{
    protected $table = "flights_classes";

    protected $fillable = [
        'name', 
        'description'
    ];

    public function flights()
    {
        return $this->belongsToMany(Flight::class, 'flight_class', 'flight_class_id', 'flight_id')
                    ->withPivot('price', 'available_seats')
                    ->withTimestamps();
    }

      public function tickets()
    {
        return $this->hasMany(tickets::class, 'class_id');
    }
}

  