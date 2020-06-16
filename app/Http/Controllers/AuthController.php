<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\SaveRequest;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Logs in the user.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            abort(401, 'Invalid login credentials');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logs out the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return $this->apiMessageResponse('Successfully logged out');
    }

    /**
     * Refreshes the auth token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Creates a new user.
     *
     * @param SaveRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(SaveRequest $request)
    {
        return $this->apiDataResponse(User::create($request->validated())->toArray(), 201);
    }

    /**
     * Formats successful auth attempts.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    private function respondWithToken(string $token)
    {
        return $this->apiDataResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
