<?php

namespace Modules\User\Http\Controllers\API;

use Modules\User\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Get the profile of current user.
     */
    public function show(Request $request)
    {
        return new UserResource($request->user()->load(['roles']));
    }

    /**
     * Update the profile of current user.
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();

        if ($avatar = $request->file('avatar')) {
            $data['avatar'] = $avatar->store('avatars');
        }

        if (! empty($password = $request->string('password'))) {
            $data['password'] = Hash::make($password);
        }

        $user->update($data);

        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();
        }

        return new UserResource($user->load(['roles']));
    }
}
