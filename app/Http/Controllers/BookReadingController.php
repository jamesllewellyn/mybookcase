<?php

namespace App\Http\Controllers;

use App\UserBook;
use App\Shelf;
use App\Book;
use App\Traits\ApiResponse;

class BookReadingController extends Controller
{
    use ApiResponse;


    public function index()
    {
        $reading = auth()->user()->reading()->simplePaginate(10);

        return $this->apiSuccess(['reading' => $reading]);
    }

    /**
     * Toggle book read
     *
     * @param  String $isbn
     * @return \Illuminate\Http\Response
     */
    public function update($isbn)
    {
        $user = auth()->user();

        $book = Book::findByISBN($isbn);

        if (!$book) {
            return $this->apiFail(['message' => 'Book could not be found']);
        }

        if(! $user->hasBook($book->id)){
            $user->addBook($book);
        }

        $userBook = UserBook::where(['user_id' => $user->id, 'book_id' => $book->id])->first();

        $userBook->update([
            'reading' => !$userBook->reading,
            'read'    => false
        ]);

        return $this->apiSuccess(['message' => 'Book reading status updated', 'reading' => $userBook->reading]);
    }

}
