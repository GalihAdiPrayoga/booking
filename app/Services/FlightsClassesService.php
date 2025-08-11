<?php

namespace App\Services;

use App\Models\FlightsClasses;

class FlightsClassesService
{
    /**
     * Map data untuk penyimpanan baru (store).
     *
     * @param array $data
     * @return array
     */
    public function mapStore(array $data): array
    {
        return [
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ];
    }

    /**
     * Map data untuk update.
     *
     * @param array $data
     * @param FlightsClasses $flightsClass
     * @return array
     */
    public function mapUpdate(array $data, FlightsClasses $flightsClass): array
    {
        return [
            'name' => $data['name'] ?? $flightsClass->name,
            'description' => $data['description'] ?? $flightsClass->description,
        ];
    }
}
