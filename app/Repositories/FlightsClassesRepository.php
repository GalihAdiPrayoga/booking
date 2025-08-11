<?php

namespace App\Repositories;

use App\Models\flightsclasses;
use App\Interfaces\FlightsClassesInterface;

class FlightsClassesRepository extends BaseRepository implements FlightsClassesInterface
{
    public function __construct(flightsclasses $flightclasses)
    {
        $this->model = $flightclasses;
    }
}
