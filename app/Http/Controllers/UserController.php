<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * get logged in user data
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->apiSuccess(['user' => User::where('id', auth()->user()->id)->withCount('read', 'reading', 'pendingFriendRequests')->first()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();

        $request->merge(['handle' => str_replace(' ', '', strtolower($request->handle))]);

        $this->validate(request(), $user->validation);

        $user = $user->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'handle'   => $request->handle,
            'password' => Hash::make($request->password),
        ]);

        return $this->apiSuccess(['message' => 'User have been registered', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $this->authorize('access-user', [$user]);

        $request->merge(['handle' => str_replace(' ', '', strtolower($request->handle))]);

        $this->validate(Request(), $user->updateValidation());

        $user->update([
            'name'   => $request->name,
            'handle' => $request->handle,
        ]);

        return $this->apiSuccess(['message' => 'user has been updated', 'user' => $user]);
    }
}
