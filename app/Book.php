<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

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
}