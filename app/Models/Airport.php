<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model

{
     use SoftDeletes;
    protected $table = "Airports";

    protected $fillable = ['code','name','city','country'];

     public function departures()
    {
        return $this->hasMany(Flight::class, 'origin_airport_id');
    }

    public function arrivals()
    {
        return $this->hasMany(Flight::class, 'destination_airport_id');
    }
}
