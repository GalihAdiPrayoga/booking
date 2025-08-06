<?php

namespace App\Repositories;

use App\Models\Airport;
use App\Interfaces\AirportsInterface;

class AirportsRepository extends BaseRepository implements AirportsInterface
{
    public function __construct(Airport $airport)
    {
        $this->model = $airport;
    }
}
