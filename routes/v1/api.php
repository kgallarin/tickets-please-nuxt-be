<?php

use App\Http\Controllers\Api\v1\TicketController;
use App\Http\Controllers\Api\v1\UsersController;


// api/v1/tickets
// will not show functionalities like showing forms for web

// ensure that the user is authenticated
Route::middleware('auth:sanctum')->apiResource('tickets', TicketController::class);

Route::middleware('auth:sanctum')->apiResource('users', UsersController::class);
