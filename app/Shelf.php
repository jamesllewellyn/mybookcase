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