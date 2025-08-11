<?php

namespace App\Services;
use Illuminate\Support\Arr;

class FlightService
{
    public function mapStore(array $data): array
    {
        // Data flight
        $flightData = Arr::except($data, ['classes']);

        // Data pivot classes
        $pivotData = [];
        foreach ($data['classes'] as $class) {
            $pivotData[$class['id']] = [
                'price' => $class['price'],
                'available_seats' => $class['available_seats'],
            ];
        }

        return [
            'flight' => $flightData,
            'pivot' => $pivotData
        ];
    }

    public function mapUpdate(array $data): array
    {
        return $this->mapStore($data);
    }
}
