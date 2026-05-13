<?php

use App\Http\Controllers\Api\v1\TicketController;
use App\Http\Controllers\Api\v1\UsersController;
use App\Http\Controllers\Api\v1\UserTicketsController;


// api/v1/tickets
// will not show functionalities like showing forms for web

// ensure that the user is authenticated
Route::middleware('auth:sanctum')->apiResource('tickets', TicketController::class);

Route::middleware('auth:sanctum')->apiResource('authors', UsersController::class);

Route::middleware('auth:sanctum')->apiResource('authors.tickets', UserTicketsController::class);
