<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserBook;

class Book extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['read', 'reading'];

    public $table = "books";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'authors' => 'array',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'authors', 'image', 'isbn', 'isbn_13'
    ];

    /**
     * Modal validation.
     *
     * @var array
     */
    public $validation = [
        'title'   => 'required',
        'authors'   => 'required',
        'isbn'    => 'required',
        'isbn_13' => 'required'
    ];

    /**
     * Custom validation messages
     *
     * @var array
     */
    public $messages = [
    ];

    /***********************
     * Eloquent Relationships
     **********************/


    public function shelves()
    {
        return $this->belongsToMany(Shelf::class, 'shelf_books')
            ->wherePivot('deleted_at', '=', null)->withTimestamps();
    }

    public static function findByISBN($isbn)
    {
        return static::where(['isbn' => $isbn])->first();
    }


    public function getReadAttribute()
    {
        return UserBook::where(['book_id' => $this->id, 'user_id' => auth()->user()->id])->first()->read;
    }

    public function getReadingAttribute()
    {
        return UserBook::where(['book_id' => $this->id, 'user_id' => auth()->user()->id])->first()->reading;
    }
}