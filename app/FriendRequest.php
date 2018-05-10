<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\FriendRequestAcceptedNotification;

class FriendRequest extends Model {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public $table = "friend_requests";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'friend_id', 'accepted', 'declined'
    ];

    /**
     * Modal validation.
     *
     * @var array
     */
    public $validation = [
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function friend()
    {
        return $this->hasOne(User::class, 'id', 'friend_id');
    }

    /***********************
     * Get Methods
     **********************/

    public function getUser()
    {
        return $this->user()->first();
    }

    public function getFriend()
    {
        return $this->friend()->first();
    }

    /***********************
     * Action Methods
     **********************/

    public function accept()
    {
        $this->getFriend()->friends()->attach($this->getUser()->id);

        $this->getUser()->friends()->attach( $this->getFriend()->id);

        $this->update([
           'accepted' => true
        ]);

        $this->delete();

        return $this->getUser()->notify(new FriendRequestAcceptedNotification($this->getFriend()));
    }
}