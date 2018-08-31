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
     * @param  String  $isbn
     * @return \Illuminate\Http\Response
     */
    public function update($isbn)
    {
        $user = auth()->user();

        $book = Book::findByISBN($isbn);

        if(! $book){
            return $this->apiFail(['message' => 'Book could not be found']);
        }

        $userBook = UserBook::where(['user_id' => $user->id, 'book_id' => $book->id])->first();

        if(! $userBook){
            $user->addBook($book);
        }

        $userBook->update([
            'reading' => !$userBook->reading
        ]);

        return $this->apiSuccess(['message' => 'Book reading status updated']);
    }

}
