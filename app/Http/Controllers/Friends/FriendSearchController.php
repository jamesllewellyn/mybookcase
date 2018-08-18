<?php

namespace App\Http\Controllers\Friends;

use App\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class FriendSearchController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = $request->search;

        $user = new User();

        $users = User::where(function ($query) use ($filter, $user) {
            foreach($user->filterable as $field)
            {
                $query->where($field, 'like', "%{$filter}%", "or");
            }
        });
        return $this->apiSuccess(['users' => $users->orderBy('name')->take(5)->get()]);
    }
}
