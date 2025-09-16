<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_id' => $this->booking_id,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            // Menampilkan data booking dan passengers jika di-load
            'booking' => $this->whenLoaded('booking', function () {
                return [
                    'id' => $this->booking->id,
                    'user_id' => $this->booking->user_id,
                    'booking_date' => $this->booking->booking_date,
                    'status' => $this->booking->status,
                    'passengers' => $this->booking->passengers->map(function ($passenger) {
                        return [
                            'id' => $passenger->id,
                            'ticket_id' => $passenger->ticket_id,
                            'name' => $passenger->name,
                            'identity_number' => $passenger->identity_number,
                        ];
                    }),
                ];
            }),
        ];
    }
}