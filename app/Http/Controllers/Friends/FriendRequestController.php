<?php

namespace App\Http\Controllers\Friends;

use App\FriendRequest;
use Illuminate\Http\Request;
use App\User;
use App\Traits\ApiResponse;
use App\Notifications\FriendRequest as FriendRequestNotification;
use App\Http\Controllers\Controller;

class FriendRequestController extends Controller
{
    use ApiResponse;

    /**
     * Store a newly created resource in storage.
     *
     * @param  User $friend
     * @return \Illuminate\Http\Response
     */
    public function create(User $friend)
    {
        $user = request()->user();

        if($user->hasPendingFriendRequests($friend->id)){
            return $this->apiFail(['message' => "You already have a pending friend request with {$friend->name}"]);
        }

        if($user->hasFriend($friend->id)){
            return $this->apiFail(['message' => "You are already friends with {$friend->name}"]);
        }

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
     * @param  FriendRequest $friendRequest
     * @return \Illuminate\Http\Response
     */
    public function update(FriendRequest $friendRequest)
    {
        $user = request()->user();

        if($friendRequest->friend_id !== $user->id){
            return $this->apiFail(['message' => "You do not have access to this friend request"]);
        }

        if(!request()->exists('accept')){
            return $this->apiFail(['message' => "Accept true or false is required"]);
        }

        if(request()->accept){
            $friendRequest->accept();
        }

        if(! request()->accept){
            $friendRequest->decline();
        }

        $friend = $friendRequest->getUser();

        return $this->apiSuccess(['message' => "You are now friends with {$friend->name}" , 'friend' => $friend]);
    }


    /**
     * Delete friend request.
     *
     * @param  FriendRequest $friendRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(FriendRequest $friendRequest)
    {
        $this->authorize('access-friend-request', [$friendRequest]);

        $friendRequest->delete();

        return $this->apiSuccess(['message' => 'Friend request has been rescinded']);
    }
}
