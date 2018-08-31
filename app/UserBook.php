<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserBook extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $table = "user_books";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'book_id', 'reading', 'read'
    ];

    /**
     * Modal validation.
     *
     * @var array
     */
    public $validation = [
        'user_id' => 'required', 'book_id' => 'required'
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
}