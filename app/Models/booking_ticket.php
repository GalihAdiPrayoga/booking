<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class booking_ticket extends Model
{
    protected $table = 'booking_ticket';

    protected $fillable = ['booking_id', 'ticket_id'];
}
