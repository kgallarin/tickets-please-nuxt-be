<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(ApiLoginRequest $request): JsonResponse
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('email', 'password'))) {
           return $this->error('Invalid Credentials', 401);
        }

        // else

        $user = User::firstWhere('email', $request->email);

        return $this->success('Login Successful', [
            'token' => $user->createToken('API token for'. $user->email)->plainTextToken,
        ]);
    }

    public function register(): JsonResponse
    {
//        return $this->success('Hello Register!');
    }
}
