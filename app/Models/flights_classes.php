<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\tickets;
class flights_classes extends Model
{
     protected $fillable = ['name', 'description'];

    public function tickets()
    {
        return $this->hasMany(tickets::class, 'class_id');
    }
}
