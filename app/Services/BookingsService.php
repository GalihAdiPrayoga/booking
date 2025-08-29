<?php

namespace App\Services;

class BookingsService
{
    public function mapStore(array $data): array
    {
        return [
            'user_id'      => $data['user_id'],
            'booking_date' => $data['booking_date'],
            'status'       => $data['status'],
        ];
    }

    public function mapUpdate(array $data): array
    {
        return [
            'booking_date' => $data['booking_date'] ?? null,
            'status'       => $data['status'] ?? null,
        ];
    }
}
