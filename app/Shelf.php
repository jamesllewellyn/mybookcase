<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Api\GoogleBooks;
use App\Api\ISBNdb;
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
        return $this->belongsToMany(Book::class, 'shelf_books')
            ->wherePivot('deleted_at', '=', null)->withTimestamps();
    }

//    public function books()
//    {
//        return $this->hasMany(ShelfBook::class, 'shelf_id', 'id');
//    }

    /***********************
     * Boolean Methods
     **********************/

    public function hasBook($isbn)
    {
        return $this->books()->where('isbn', $isbn)->first() ? true : false;
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
        $ISBNdb = New ISBNdb();
        return $this->books()->skip($perPage * ($currentPage - 1))->take($perPage)->get()->map(function ($book) use ($ISBNdb) {
//            dd();
//            return Cache::remember("google-books.isbn.{$book->isbn}", 1440, function () use ($ISBNdb, $book) {
                return $ISBNdb->getBook($book->isbn);
//            });
        })->filter()->all();
    }

    public function getFirstBook()
    {
        return $this->books()->first();
    }

    /***********************
     * Action API Methods
     **********************/

    public function addBook($isbn, $isbn_13 = false)
    {
        if ($this->hasBook($isbn)) {
            return false;
        }

        $book = Book::findByISBN($isbn);

        $this->books()->attach($book->id);

        return $book;
    }

    public function removeBook($isbn)
    {
        if (! $this->hasBook($isbn)) {
            return false;
        }

        $book = Book::findByISBN($isbn);

        $this->books()->detach($book->id);

        return $book;
    }

}