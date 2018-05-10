<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Api\GoogleBooks;
use App\ShelfBook;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Cache;

class Shelf extends Model
{
    use SoftDeletes, ApiResponse;

    protected $dates = ['deleted_at'];

    public $table = "shelves";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'public'
    ];

    /**
     * Modal validation.
     *
     * @var array
     */
    public $validation = [
        'name'   => 'required',
        'public' => 'sometimes'
    ];

    /**
     * Custom validation messages
     *
     * @var array
     */
    public $messages = [
        'name.required' => 'Please provide a name for your new shelf'
    ];

    /***********************
     * Eloquent Relationships
     **********************/

    /**
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function books()
    {
        return $this->hasMany(ShelfBook::class, 'shelf_id', 'id');
    }

    /***********************
     * Boolean Methods
     **********************/

    public function hasBook($isnb)
    {
        return $this->books()->where('isbn', $isnb)->first() ? true : false;
    }

    public function isPublic()
    {
        return $this->public ? true : false;
    }

    /***********************
     * Get Methods
     **********************/

    public function getBooksPaginated($perPage = 10, $currentPage)
    {
        $googleBooks = New GoogleBooks();
        return $this->books()->skip($perPage * ($currentPage - 1))->take($perPage)->get()->map(function ($book) use ($googleBooks) {
            return Cache::remember("google-books.isbn.{$book->isbn}", 1440, function () use ($googleBooks, $book) {
                return $googleBooks->getBook($book->isbn);
            });
        })->filter()->all();
    }

    public function getFirstBook()
    {
        $book = $this->hasMany(ShelfBook::class, 'shelf_id', 'id')->first();
        if(!$book){
            return false;
        }
        return $this->getBook($book);
    }

    public function getBook($book)
    {
        $googleBooks = New GoogleBooks();

        return Cache::remember("google-books.isbn.{$book->isbn}", 1440, function () use ($googleBooks, $book) {
            return $googleBooks->getBook($book->isbn);
        });
    }

    /***********************
     * Action API Methods
     **********************/

    public function addBook($isbn, $isbn_13 = false)
    {
        if ($this->hasBook($isbn)) {
            return $this->apiFail(['message' => "Book is already on shelf {$this->name}"]);
        }

        $shelfBook = $this->books()->create([
            'isbn'    => $isbn,
            'isbn_13' => isset($isbn_13) ? $isbn_13 : null
        ]);

        return $this->apiSuccess(['message' => "Book has been added to shelf {$this->name}", 'book' => $shelfBook]);
    }

    public function removeBook($isbn)
    {
        if (!$this->hasBook($isbn)) {
            return $this->apiFail(['message' => "That book doesn't seem to be on that shelf"]);
        }

        $this->books()->where('isbn', $isbn)->first()->delete();

        return $this->apiSuccess(['message' => "Book has been removed from shelf {$this->name}", 'isbn' => $isbn]);
    }

}