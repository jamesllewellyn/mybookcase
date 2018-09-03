<?php

namespace App\Http\Controllers;

use App\Shelf;
use App\ShelfBook;
use App\UserBook;
use App\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ShelfBookController extends Controller
{
    use ApiResponse;
    /**
     * List books on shelf.
     *
     * @param  Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function index(Shelf $shelf)
    {
        $this->authorize('access-shelf', [$shelf]);

        $books = $shelf->books()->simplePaginate(10);

        return $this->apiSuccess(['books' => $books]);
    }

    /**
     * Add book to shelf
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Shelf $shelf
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shelf $shelf)
    {
        $this->authorize('access-shelf', [$shelf]);

        $user = auth()->user();

        $shelfBook = new ShelfBook();
        /** validate the request data */
        $this->validate(Request(), $shelfBook->validation, $shelfBook->messages);

        if($shelf->hasBook($request->get('isbn'))){
            return $this->apiFail(['message' => 'Book is already on this shelf']);
        }

        $book = $shelf->addBook($request->get('isbn'), $request->get('isbn_13'));

        if(! $user->hasBook($book->id)){
            $user->addBook($book);
        }

        /** return success and added book*/
        return  $this->apiSuccess(['message' => "Book has been added to shelf {$shelf->name}", 'book' => $book]);
    }

    /**
     * Move book to different shelf.
     *
     * @param  User $user
     * @param  Shelf $shelf
     * @param  String $isbn
     * @return \Illuminate\Http\Resources\Json
     */
    public function update(Shelf $shelf, $isbn)
    {
        $this->authorize('access-shelf', [$shelf]);

        if(!request()->get('new_shelf_id')){
            return $this->apiFail(['message' => 'Place provide a shelf to move the book to']);
        }

        if(! $shelf->hasBook($isbn)){
            return $this->apiFail(['message' => "Book could not be found on shelf {$shelf->name}"]);
        }

        $newShelf = Shelf::find(request()->get('new_shelf_id'));

        if(! $newShelf){
            return $this->apiFail(['message' => "Shelf could not be found"]);
        }

        $this->authorize('access-shelf', [$newShelf]);

        if(! $shelf->removeBook($isbn)){
            return $this->apiFail(['message' => "This book doesn't seem to be on shelf {$shelf->name}"]);
        }

        $book = $newShelf->addBook($isbn);

        if(! $book){
            return $this->apiFail(['message' => "This book is already on shelf {$newShelf->name}"]);
        }

        $book->shelf_id = $newShelf->id;

        return $this->apiFail(['message' => "{$book->title} has been added to shelf {$newShelf->name}", 'book' => $book]);
    }

    /**
     * Remove book from shelf.
     *
     * @param  User $user
     * @param  Shelf $shelf
     * @param  String $isbn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shelf $shelf, $isbn)
    {
        $this->authorize('access-shelf', [$shelf]);

        $book = $shelf->removeBook($isbn);

        if(! $book){
            return $this->apiFail(['message' => "This book doesn't seem to be on shelf {$shelf->name}"]);
        }

        return $this->apiFail(['message' => "{$book->title} has been removed from shelf {$shelf->name}", 'book' => $book]);
    }
}
