<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        return $this->success('Login Successful',
            [
                'token' => $user->createToken(
                    'API token for'. $user->email,
                    ['*'],
                    now()->addMonth()
                )->plainTextToken,
            ]
        );
    }

    public function register(): JsonResponse
    {
        // return $this->success('Hello Register!');
    }

    public function logout(Request $request): JsonResponse
    {
        // we dont want this approach because what if user has token that does not expire? might be a service or
        //  $request->user()->tokens()->delete();

        // not this approach as weell because we dont have the id of the token
        //  $request->user()->tokens()->where('id', $tokenId)->delete();

        $request->user()->currentAccessToken()->delete();

        return $this->success('Logout Successful');
    }
}
