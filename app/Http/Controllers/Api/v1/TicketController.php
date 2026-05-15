<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\Api\v1\TicketFilter;
use App\Http\Requests\Api\v1\StoreTicketRequest;
use App\Http\Requests\Api\v1\UpdateTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filter): AnonymousResourceCollection
    {

        return TicketResource::collection(Ticket::filter($filter)->paginate());
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
    public function store(StoreTicketRequest $request)
    {
        //  we dont need to validate here because it is done in the store request

        // wrap in try catch

        // but as of this using Laravel 13, the validation is done in the store request maybe just extend the message for the user
        try {
            $user = User::findOrFail($request->input('data.relationships.user.data.id'));
        } catch (ModelNotFoundException $e) {
            // we can actually do this here but for security reasons we just use success
            // return $this->error('User not found', 401);
            return $this->success('User not found', [
                'error' => 'User not found',
            ]);
        }

        // if we do not have error validations
        // do not forget to add these in fillables in the model
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $request->input('data.relationships.user.data.id'),
        ];

        // create a ticket then pass the $model variable
        return new TicketResource( Ticket::create($model));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket, TicketFilter $filter): TicketResource
    {
//        if($filter->include('author')) {
//            return TicketResource::make($ticket->load('author'));
//        }

        return TicketResource::make(Ticket::filter($filter)->make($ticket->id));
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
