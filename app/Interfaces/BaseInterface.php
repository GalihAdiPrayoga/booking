<?php

namespace App\Interfaces;

use App\Interfaces\Eloquent\DeleteInterface;
use App\Interfaces\Eloquent\GetInterface;
use App\Interfaces\Eloquent\ShowInterface;
use App\Interfaces\Eloquent\StoreInterface;
use App\Interfaces\Eloquent\UpdateInterface;

interface BaseInterface extends GetInterface, StoreInterface, ShowInterface, UpdateInterface, DeleteInterface
{

}



