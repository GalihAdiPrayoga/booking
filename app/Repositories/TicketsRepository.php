<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Interfaces\TicketsInterface;

class TicketsRepository extends BaseRepository implements TicketsInterface
{
    public function __construct(Ticket $tickets)
    {
        $this->model = $tickets;
    }

   
}