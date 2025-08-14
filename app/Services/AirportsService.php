<?php

namespace App\Services;

use App\Http\Requests\AirportsRequest;
use App\Http\Resources\AirportsResource;
use App\Interfaces\AirportsInterface;
use App\Helpers\ResponseHelper;

class AirportsService
{
    protected AirportsInterface $airportsRepository;

    public function __construct(AirportsInterface $airportsRepository)
    {
        $this->airportsRepository = $airportsRepository;
    }

    public function mapStore(AirportsRequest $request): array
    {
        $data = $request->validated();

        return [
            'name' => $data['name'] ?? null,
            'code' => $data['code'] ?? null,
            'city' => $data['city'] ?? null,
            'country' => $data['country'] ?? null,
        ];
    }

    public function mapUpdate(array $validated, $airport): array
    {
        return [
            'name' => $validated['name'] ?? $airport->name,
            'code' => $validated['code'] ?? $airport->code,
            'city' => $validated['city'] ?? $airport->city,
            'country' => $validated['country'] ?? $airport->country,
        ];
    }

}
