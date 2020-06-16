<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if(!$token = auth()->attempt($request->validated())){
            abort(401, 'Invalid login credentials');
        }

        return $this->respondWithToken($token);
    }

    private function respondWithToken(string $token){

    }
}
