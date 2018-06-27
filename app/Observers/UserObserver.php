<?php

namespace App\Observers;

use App\User;
use App\Jobs\User\CreateDefaultShelves;
use App\Notifications\UserWelcome;

class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        CreateDefaultShelves::dispatch($user);

        $user->notify(new UserWelcome());
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }
}