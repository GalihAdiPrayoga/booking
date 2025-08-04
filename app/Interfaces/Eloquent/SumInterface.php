<?php

namespace App\Interfaces\Eloquent;

interface SumInterface
{
    /**
     * Handle sum data event from models.
     *
     * @return int
     */

    public function sum(): int;
}
