<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketsRequest;
use App\Models\Tickets;
use App\Helpers\ResponseHelper;

class TicketsController extends Controller
{
    public function index()
    {
        $tickets = Tickets::all();
        return ResponseHelper::success($tickets);
    }

    public function store(TicketsRequest $request)
    {
        $ticket = Tickets::create($request->validated());

        return ResponseHelper::success($ticket, trans('alert.add_success'));
    }

    public function update(TicketsRequest $request, Tickets $ticket)
    {
        $ticket->update($request->validated());

        return ResponseHelper::success($ticket, trans('alert.update_success'));
    }

    public function destroy(Tickets $ticket)
    {
        $ticket->delete();
        return ResponseHelper::success(message: trans('alert.delete_success'));
    }
}
