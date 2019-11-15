<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('guest-create', function ($user) {
            $permissions = json_decode($user->permissions);
            if(in_array("L1", $permissions)) {
                return true;
            }
            return false;
        });

        Gate::define('guest-assign', function ($user) {
            $permissions = json_decode($user->permissions);
            if(in_array("L1", $permissions)) {
                return true;
            }
            return false;
        });

        Gate::define('guest-thank-you', function ($user) {
            $permissions = json_decode($user->permissions);
            if(in_array("L1", $permissions)) {
                return true;
            }
            return false;
        });

        Gate::define('guest-list', function ($user) {
            $permissions = json_decode($user->permissions);
            if(in_array("L2", $permissions)) {
                return true;
            }
            return false;
        });

        Gate::define('guest-review', function ($user) {
            $permissions = json_decode($user->permissions);
            if(in_array("L2", $permissions)) {
                return true;
            }
            return false;
        });

        Gate::define('onlyAdmin', function($user){
            return $user->role_id == 1;
        });
    }
}
