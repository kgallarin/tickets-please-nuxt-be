<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\StoreTicketRequest;
use App\Http\Requests\Api\v1\UpdateTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        if($this->include('author')) {
            return TicketResource::collection(Ticket::with('author')->paginate());
        }

        return TicketResource::collection(Ticket::paginate());
    }

    /**
     * Show the form for creating a new resource.
     * Web type not necessary
     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket): TicketResource
    {
        if($this->include('author')) {
            return TicketResource::make($ticket->load('author'));
        }

        return TicketResource::make($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     * Web type not necessary
     */
//    public function edit(Ticket $ticket)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): void
    {
        //
    }
}
