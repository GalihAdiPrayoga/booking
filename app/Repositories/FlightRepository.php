<?php

namespace App\Repositories;

use App\Models\Flight;
use App\Interfaces\FlightInterface;

class FlightRepository extends BaseRepository implements FlightInterface
{
    public function __construct(Flight $flight)
    {
        $this->model = $flight;
    }

    public function store(array $payload): mixed
    {
        $flight = $this->model->create($payload['flight']);

        if (!empty($payload['pivot'])) {
            $flight->classes()->attach($payload['pivot']);
        }

        return $flight->load(['origin', 'destination', 'classes']);
    }

    public function update(mixed $id, array $payload): mixed
    {
        $flight = $this->show($id);

        $flight->update($payload['flight']);

        if (!empty($payload['pivot'])) {
            $flight->classes()->sync($payload['pivot']);
        }

        return $flight->load(['origin', 'destination', 'classes']);
    }
}

