<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Filters\Api\v1\TicketFilter;
use App\Http\Resources\v1\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class UserTicketsController extends Controller
{
  public function index($user_id, TicketFilter $filter) {
      // before
      //  return TicketResource::collection(Ticket::where('user_id', $user_id)->paginate());

      // now we can use the filters here like so:
      return TicketResource::collection(Ticket::where('user_id', $user_id)->filter($filter)->paginate());

  }
}
