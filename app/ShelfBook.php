<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShelfBook extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public $table = "shelf_books";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'isbn', 'isbn_13', 'shelf_id', 'read'
    ];

    /**
     * Modal validation.
     *
     * @var array
     */
    public $validation = [
        'ibsn'    => 'required_if:isbn_13,null',
        'isbn_13' => 'required_if:ibsn,null'
    ];

    /**
     * Custom validation messages
     *
     * @var array
     */
    public $messages = [
        'ibsn.required_if'    => 'Please provide either an isbn or an isbn 13 number',
        'isbn_13.required_if' => 'Please provide either an isbn or an isbn 13 number'
    ];

    /***********************
     * Eloquent Relationships
     **********************/
    public function user()
    {
        return $this->belongsTo(Shelf::class, 'id', 'shelf_id');
    }
}