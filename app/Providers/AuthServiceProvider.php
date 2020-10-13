<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $checkUserType = config('customarray.userType');

        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return ($user->user_type === $checkUserType['ADMIN']) ? Response::allow() : Response::deny('You Are Not Authorized to Access This Page.');
        });

        Gate::define('isUser', function ($user) {
            return $user->user_type === $checkUserType['USER'] ? Response::allow() : Response::deny('You Are Not Authorized to Access This Page.');
        });

    }
}
