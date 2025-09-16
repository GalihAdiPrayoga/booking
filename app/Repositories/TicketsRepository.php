<?php

namespace App\Repositories;

use App\Models\Tickets;

class TicketsRepository
{
    public function create(array $data): Tickets
    {
        return Tickets::create($data);
    }

    public function all()
    {
        return Tickets::all();
    }

    public function find($id): ?Tickets
    {
        return Tickets::find($id);
    }

    public function update(Tickets $tickets, array $data): Tickets
    {
        $tickets->update($data);
        return $tickets;
    }

    public function delete(Tickets $tickets): bool
    {
        return $tickets->delete();
    }
}
