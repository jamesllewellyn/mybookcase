<?php

namespace App\Http\Controllers;

use App\FriendRequest;
use Illuminate\Http\Request;
use App\User;
use App\Traits\ApiResponse;
use App\Notifications\FriendRequest as FriendRequestNotification;
;

class FriendRequestController extends Controller
{
    use ApiResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param  User $user
     * @param  User $friend
     * @return \Illuminate\Http\Response
     */
    public function create(User $user, User $friend)
    {
        FriendRequest::create([
            'user_id'   => $user->id,
            'friend_id' => $friend->id,
        ]);

        $friend->notify(new FriendRequestNotification($user));

        return $this->apiSuccess(['message' => "Friend request has been sent to {$friend->name}", 'friends' => $friend]);
    }

    /**
     * Accept / decline friend request.
     *
     * @param  User $user
     * @param  User $friend
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, User $friend)
    {
        if(!request()->exists('accept')){
            return $this->apiFail(['message' => "Accept true or false is required"]);
        }

        $friendRequest = FriendRequest::where([
            'user_id'   => $friend->id,
            'friend_id' => $user->id
        ])->firstOrFail();

        if(request()->accept){
            $friendRequest->accept();
        }

        if(! request()->accept){
            $friendRequest->decline();
        }

        return $this->apiSuccess(['message' => "You are now friends with {$friend->name}" , 'friend' => $friend]);
    }


    /**
     * Gets public profile shelf.
     *
     * @param  User $user
     * @param  FriendRequest $friendRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, FriendRequest $friendRequest)
    {
        $this->authorize('access-friend-request', [$friendRequest]);

        $friendRequest->delete();

        return $this->apiSuccess(['message' => 'Friend request has been rescinded']);
    }
}
