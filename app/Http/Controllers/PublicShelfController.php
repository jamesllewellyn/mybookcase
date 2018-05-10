<?php

namespace App\Http\Controllers;

use App\Shelf;
use App\Traits\ApiResponse;
use App\User;

class PublicShelfController extends Controller
{
    use ApiResponse;

    /**
     * Gets users public profile and shelves.
     *
     * @param  String $handle
     * @return \Illuminate\Http\Response
     */
    public function index($handle)
    {
        $user = User::getByHandle(str_replace('@','',$handle));

        $shelves = $user->getPublicShelves();

        $shelvesWithBooks = $shelves->map(function($shelf){
            $book = $shelf->getFirstBook();
            $shelf =  $shelf->toArray();
            $shelf['book'] =  $book;
            return $shelf;
        });

        return $this->apiSuccess(['user' => $user, 'shelves' => $shelvesWithBooks]);
    }


    /**
     * Gets public profile shelf.
     *
     * @param  String $handle
     * @param  Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function show($handle, Shelf $shelf)
    {
        $user = User::getByHandle($handle);

        $this->authorize('access-public-shelf', [$user, $shelf]);

        $shelf = Shelf::where('id', $shelf->id)->first();

        return $this->apiSuccess(['message' => 'shelf has been found', 'shelf' => $shelf,  'user' => $user]);
    }

}
