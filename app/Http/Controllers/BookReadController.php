<?php

namespace App\Http\Controllers;

use App\ShelfBook;
use App\Shelf;
use App\Book;
use App\Traits\ApiResponse;

class BookReadController extends Controller
{
    use ApiResponse;

    /**
     * Toggle book read
     *
     * @param  Shelf $shelf
     * @param  String  $isbn
     * @return \Illuminate\Http\Response
     */
    public function update(Shelf $shelf, $isbn)
    {
        $this->authorize('access-shelf', [$shelf]);

        $book = Book::findByISBN($isbn);

        if(! $book){
            return $this->apiFail(['message' => 'Book could not be found']);
        }

        $shelfBook = ShelfBook::where(['shelf_id' => $shelf->id, 'book_id' => $book->id])->first();


        if(! $shelfBook){
            return $this->apiFail(['message' => 'Book could not be found']);
        }

        $shelfBook->update([
            'read' => !$shelfBook->read
        ]);

        return $this->apiSuccess(['message' => 'Book read status updated']);
    }

}
