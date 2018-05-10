<?php

namespace App\Observers;

use App\User;
use App\Jobs\User\CreateDefaultShelves;

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
        /** Create Users Default Shelves */
        CreateDefaultShelves::dispatch($user);
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