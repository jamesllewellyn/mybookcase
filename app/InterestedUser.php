<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\InviteInterestedUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class InterestedUser extends Model {

    use Notifiable, SoftDeletes;

    public $table = "interested_users";

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'token', 'invite_sent'
    ];

    /**
     * Modal validation.
     *
     * @var array
     */
    public $validation = [
        'email' => 'email|required|unique:users,email|unique:interested_users,email'
    ];

    /**
     * Custom validation messages
     *
     * @var array
     */
    public $messages = [
        'email.unique' => 'Looks like this email address has already been registered'
    ];

    /***********************
     * Methods
     **********************/

    /**
     * Get pending user using email and token
     * @var string $email
     * @var string $token
     * @return InterestedUser
     */
    public static function findByEmailAndToken($email, $token)
    {
        return static::where(['email' => $email, 'token' => $token])->first();
    }

    public static function deleteByEmail($email)
    {
        return static::where(['email' => $email])->first()->delete();
    }

    public static function toInvite(){
        return InterestedUser::where('invite_sent', null)->get();
    }

    public function invite()
    {
        $this->notify(new InviteInterestedUser());

        return $this->update([
            'invite_sent' => Carbon::now()
        ]);
    }

}