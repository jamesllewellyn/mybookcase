<?php

namespace App\Http\Controllers\Friends;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class FriendController extends Controller
{
    use ApiResponse;

    /**
     * List all logged in users Friends.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pendingFriendRequest = $request->user()->getPendingFriendRequests();

        $sentFriendRequest = $request->user()->getSentFriendRequests();

        $friend = $request->user()->getFriends();

        return $this->apiSuccess(['active' => $friend, 'pending' => $pendingFriendRequest, 'sent' => $sentFriendRequest]);
    }
}
