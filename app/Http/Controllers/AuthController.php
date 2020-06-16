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
     * @return JSON
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
     * @return JSON
     */
    public function logout()
    {
        auth()->logout();

        return $this->apiMessageResponse('Successfully logged out');
    }

    /**
     * Refreshes the auth token.
     *
     * @return JSON
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Formats successful auth attempts.
     *
     * @param string $token
     * @return json
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
