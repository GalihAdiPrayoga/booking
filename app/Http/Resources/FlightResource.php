<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FlightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
  public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'airline' => $this->airline,
        'flight_number' => $this->flight_number,
        'origin' => new AirportsResource($this->origin),
        'destination' => new AirportsResource($this->destination),
        'departure_time' => $this->departure_time,
        'arrival_time' => $this->arrival_time,
        
        // Ambil harga termurah dari semua class
        'price' => $this->classes->min(fn($class) => $class->pivot->price),

        // Jumlah total kursi dari semua class
        'available_seats' => $this->classes->sum(fn($class) => $class->pivot->available_seats),

        'classes' => $this->classes->map(function ($class) {
            return [
                'id' => $class->id,
                'name' => $class->name,
                'price' => $class->pivot->price,
                'available_seats' => $class->pivot->available_seats,
            ];
        }),
    ];
}

}
