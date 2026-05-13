<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Filters\Api\v1\AuthorFilter;
use App\Http\Requests\Api\v1\StoreUserRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class UsersController extends ApiController
{
    public function index(AuthorFilter $filters) {
        // instead of using the with() method we can use the include query parameter we can rely on the query filter

       // if($this->include('tickets')) {
       //     return UserResource::collection(User::with('tickets')->paginate());
       // }

        return UserResource::collection(User::filter($filters)->paginate());
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
