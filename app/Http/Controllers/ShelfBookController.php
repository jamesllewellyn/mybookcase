<?php

namespace App\Http\Controllers;

use App\Shelf;
use App\ShelfBook;
use App\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ShelfBookController extends Controller
{
    use ApiResponse;
    /**
     * List books on shelf.
     *
     * @param  User $user
     * @param  Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Shelf $shelf)
    {
        $this->authorize('access-shelf', [$shelf]);

        $currentPage = request()->query('page') ? (int)request()->query('page') : 1;

        $books = $shelf->getBooksPaginated(10, $currentPage);

        $totalBooks = $shelf->books()->count();

        $totalPages =  ceil($totalBooks / 10);

        return $this->apiSuccess(['books' => $books, 'totalBooks' => $totalBooks , 'totalPages' => $totalPages, 'currentPage' => $currentPage]);
    }

    /**
     * Add book to shelf
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @param  Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user, Shelf $shelf)
    {
        $this->authorize('access-shelf', [$shelf]);

        $shelfBook = new ShelfBook();
        /** validate the request data */
        $this->validate(Request(), $shelfBook->validation, $shelfBook->messages);

        if($shelf->hasBook($request->get('isbn'))){
            return $this->apiFail(['message' => 'Book is already on shelf']);
        }

        $shelfBook = $shelf->addBook($request->get('isbn'), $request->get('isbn_13'));

        /** return success and requested task */
        return $this->apiSuccess(['message' => 'Book has been added to shelf', 'shelfBook' => $shelfBook]);
    }

    /**
     * Move book to different shelf.
     *
     * @param  User $user
     * @param  Shelf $shelf
     * @param  String $isbn
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Shelf $shelf, $isbn)
    {
        $this->authorize('access-shelf', [$shelf]);

        if(!request()->get('new_shelf_id')){
            return $this->apiFail(['message' => 'Place provide a shelf to move the book to']);
        }

        $book = ShelfBook::where(['shelf_id' => $shelf->id, 'isbn' => $isbn])->first();

        if(!$book){
            return $this->apiFail(['message' => 'Place provide a shelf to move the book to']);
        }

        $newShelf = Shelf::find(request()->get('new_shelf_id'));

        $this->authorize('access-shelf', [$newShelf]);

        $shelf->removeBook($book->isbn);

        return $newShelf->addBook($book->isbn, $book->isbn_13);
    }

    /**
     * Remove book from shelf.
     *
     * @param  User $user
     * @param  Shelf $shelf
     * @param  String $isbn
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Shelf $shelf, $isbn)
    {
        $this->authorize('access-shelf', [$shelf]);

        return $shelf->removeBook($isbn);
    }
}
