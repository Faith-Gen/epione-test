<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SaveRequest;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Gets the user details.
     *
     * @param User $user
     * @return void
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Updates the name of the given user.
     *
     * @param User $user
     * @param SaveRequest $request
     * @return void
     */
    public function update(User $user, SaveRequest $request)
    {
        $user->update($request->validated());

        return new UserResource($user->fresh());
    }
}