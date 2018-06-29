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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shelves = $request->user()->getShelves();

//        $friends = $request->user()->getFriends();
        return $this->apiSuccess(['user' => $request->user(), 'shelves' => $shelves, 'friends' => null]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $user = new User();

        $this->validate(request(), $user->validation);

        $user = $user->create([
            'name'     => request('name'),
            'email'    => request('email'),
            'handle'   => request('handle'),
            'password' => Hash::make(request('password')),
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
    public
    function update(Request $request, User $user)
    {
        $this->authorize('access-user', [$user]);

        $this->validate(Request(), $user->updateValidation());

        $user->update([
            'name'   => $request->name,
            'handle' => $request->handle,
        ]);

        return $this->apiSuccess(['message' => 'user has been updated', 'user' => $user]);
    }
}
