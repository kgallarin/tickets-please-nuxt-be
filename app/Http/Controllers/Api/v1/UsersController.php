<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\StoreUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class UsersController extends ApiController
{
    public function index() {
        if($this->include('tickets')) {
            return UserResource::collection(User::with('tickets')->paginate());
        }

        return UserResource::collection(User::paginate());
    }

    public function store(StoreUserRequest $request) {

    }

    public function show(User $author) {
        if($this->include('tickets')) {
            return UserResource::make($author->load('tickets'));
        }

        return UserResource::make($author);
    }
}
