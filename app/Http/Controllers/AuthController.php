<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Logs in the user.
     *
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        if (!$token = auth()->attempt($request->validated())) {
            abort(401, 'Invalid login credentials');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Formats successful auth attempts.
     *
     * @param string $token
     * @return void
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
