<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDay());

        /***********************
         * Project Gates
         **********************/
        /**
         * passes if user is accessing self
         *
         * @return bool
         */
        Gate::define('access-user', function ($user, $profile) {
            return $user->id === $profile->id;
        });

        /**
         *
         * @return bool
         */
        Gate::define('access-shelf', function ($user, $shelf) {
            return $user->canAccessShelf($shelf->id);
        });

        /**
         * passes if shelf if public and owned by user in uri
         *
         * @return bool
         */
        Gate::define('access-public-shelf', function ($user, $owner, $shelf) {
            if (!$owner->hasShelf($shelf->id)) {
                return false;
            }

            return $shelf->isPublic();
        });

        /**
         * passes if user has sent request
         *
         * @return bool
         */
        Gate::define('access-friend-request', function ($user, $friendRequest) {
            return $user->hasSentRequest($friendRequest->id);
        });
    }
}
