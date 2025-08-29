<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\tickets;
use App\Models\payments;
class bookings extends Model
{
    protected $table = "bookings";
    protected $fillable = ['user_id', 'booking_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->belongsToMany(ticket::class, 'booking_ticket');
    }

    public function payment()
    {
        return $this->hasOne(payments::class);
    }

}
