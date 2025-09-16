<?php

namespace App\Repositories;

use App\Models\Flightsclasses;
use App\Interfaces\FlightsClassesInterface;

class FlightsClassesRepository extends BaseRepository implements FlightsClassesInterface
{
    public function __construct(flightsclasses $flightclasses)
    {
        $this->model = $flightclasses;
    }
}
