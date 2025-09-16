<?php

namespace App\Http\Resources\Tickets;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'flight_id'   => $this->flight_id,
            'class_id'    => $this->class_id,
            'price'       => $this->price,
            'seat_number' => $this->seat_number,
            'status'      => $this->status,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
