<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Book;
use Illuminate\Database\Eloquent\Collection;

class ProcessBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $books;

    /**
     * Create a new job instance.
     * @param $books
     * @return mixed
     */
    public function __construct($books)
    {
        $this->books = collect($books);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->books->each(function ($book) {

            $storedBook = Book::where(['isbn' => $book->isbn])->first();


            if ($storedBook) {
                return $this->updateBook($storedBook, $book);
            }

            return $this->addBook($book);
        });
    }

    /**
     * Add book to db.
     * @param $book
     * @return Book
     */
    private function addBook($book)
    {
        return Book::create([
            'title'   => $book->title,
            'authors' => $book->authors,
            'isbn'    => $book->isbn,
            'isbn_13' => isset($book->isbn13) ? $book->isbn13 : null,
            'image'   => isset($book->image) ? $book->image : null,
        ]);
    }

    /**
     * Update book.
     * @param $storedBook
     * @param $book
     * @return Book
     */
    private function updateBook($storedBook, $book)
    {
        return $storedBook->update([
            'title'   => $book->title,
            'authors' => $book->authors,
            'isbn'    => $book->isbn,
            'isbn_13' => isset($book->isbn13) ? $book->isbn13 : null,
            'image'   => isset($book->image) ? $book->image : null,
        ]);
    }
}
