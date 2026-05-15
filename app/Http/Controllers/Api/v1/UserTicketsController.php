<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\Api\v1\TicketFilter;
use App\Http\Requests\Api\v1\StoreTicketRequest;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class UserTicketsController extends ApiController
{

  public function index($user_id, TicketFilter $filter) {
      // before
      //  return TicketResource::collection(Ticket::where('user_id', $user_id)->paginate());

      // now we can use the filters here like so:
      return TicketResource::collection(Ticket::where('user_id', $user_id)->filter($filter)->paginate());

  }

    public function store($user_id, StoreTicketRequest $request)
    {
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $user_id // <- this is coming from the route parameter
        ];

        // create a ticket then pass the $model variable
        return new TicketResource( Ticket::create($model));
    }

    public function destroy($user_id, $ticket_id)
    {
        try {
            $ticket = Ticket::findOrFail($ticket_id);
            if($ticket->user_id == $user_id) {
                $ticket->delete();
                return $this->success('Ticket successfully deleted', 200);
            }
            echo("not equal");
            return $this->error('Unauthorized to delete this ticket', 403);
        } catch (ModelNotFoundException $e) {
            return $this->error('Ticket not found', 404);
        }
    }
}
