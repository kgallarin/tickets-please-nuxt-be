<?php

use App\Http\Controllers\Api\v1\TicketController;


// api/v1/tickets
// will not show functionalities like showing forms for web
Route::apiResource('tickets', TicketController::class);
