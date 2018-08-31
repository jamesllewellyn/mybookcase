<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $appends = ['avatar_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'handle', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public $filterable = [
        'name', 'email', 'handle'
    ];

    /**
     * Modal validation.
     *
     * @var array
     */
    public $validation = [
        'name'     => 'required',
        'email'    => "required|email|unique:users,email",
        'handle'   => "required|unique:users,handle",
        'password' => "required|confirmed|min:6",
    ];

    /**
     * Modal validation.
     * @return  array
     */
    public function updateValidation()
    {
        return [
            'name'   => 'required',
            'email'  => "required|email|unique:users,id,{$this->id}",
            'handle' => "required|unique:users,id,{$this->id}"
        ];
    }


    /***********************
     * Eloquent Relationships
     **********************/

    /**
     * Get all users shelves.
     */
    public function shelves()
    {
        return $this->hasMany(Shelf::class, 'user_id', 'id');
    }

    /**
     * Get users friends.
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'user_friends', 'user_id', 'friend_id');
    }

    /**
     * Get pending friend requests this user has sent.
     */
    public function sentFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'user_id', 'id');
    }

    /**
     * Get all pending friend requests from other users.
     */
    public function pendingFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'friend_id', 'id');
    }

    /************
     * Static Methods
     ************/

    protected static function getByHandle($handle)
    {
        return User::where('handle', str_replace('@', '', $handle))->firstOrFail();
    }

    /************
     * Boolean Methods
     ************/


    public function hasShelf($shelfId)
    {
        return $this->shelves()->where('shelves.id', $shelfId)->exists();
    }

    public function hasSentRequest($friendRequestId)
    {
        return $this->sentFriendRequests()->where('friend_requests.id', $friendRequestId)->exists();
    }

    public function hasPendingFriendRequests($friendId)
    {
        $receivedRequest =  $this->pendingFriendRequests()->where('friend_requests.user_id', $friendId)->exists();
        $sendRequest = $this->sentFriendRequests()->where('friend_requests.friend_id', $friendId)->exists();
        return $receivedRequest || $sendRequest;
    }

    public function hasFriend($friendId)
    {
        return $this->friends()->where('user_friends.friend_id', $friendId)->exists();
    }

    /***********************
     * Get methods
     **********************/
    /**
     * Get users avatar url.
     */
    public function getAvatarUrlAttribute()
    {
        return asset("https://api.adorable.io/avatars/100/{$this->handle}@mybookcase.co.png");
    }

    public function getShelves()
    {
        return $this->shelves()->with('books')->withCount('books')->get();
    }

    public function getPublicShelves()
    {
        return $this->shelves()->where('public', true)->withCount('books')->get();
    }

    public function getFriends()
    {
        return $this->friends()->get();
    }

    public function getPendingFriendRequests()
    {
        return $this->pendingFriendRequests()->with('user')->get();
    }

    public function getSentFriendRequests()
    {
        return $this->sentFriendRequests()->with('friend')->get();
    }

    public function canAccessShelf($shelfId)
    {
        return $this->shelves()->where('id', $shelfId)->exists();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
