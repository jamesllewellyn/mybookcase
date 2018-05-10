<?php

namespace App\Http\Controllers;

use App\Shelf;
use App\User;
use App\Traits\ApiResponse;

class PublicShelfBookController extends Controller
{
    use ApiResponse;

    /**
     * List books on shelf.
     *
     * @param  String $handle
     * @param  Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function index($handle, Shelf $shelf)
    {
        $user = User::getByHandle($handle);

        $this->authorize('access-public-shelf', [$user, $shelf]);

        $currentPage = request()->query('page') ? (int) request()->query('page') : 1;

        $books = $shelf->getBooksPaginated(10, $currentPage);

        $totalBooks = $shelf->books()->count();

        $totalPages = ceil($totalBooks / 10);

        return $this->apiSuccess(['books' => $books, 'totalBooks' => $totalBooks, 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }
}
