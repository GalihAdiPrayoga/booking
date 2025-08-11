<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\bookings;
class payments extends Model
{
    protected $fillable = ['booking_id', 'amount', 'payment_method', 'status', 'paid_at'];

    public function booking()
    {
        return $this->belongsTo(bookings::class);
    }
}
