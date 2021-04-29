<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // Instead of manually registering model policies, Laravel can auto-discover policies as long as the model and policy follow standard Laravel naming conventions.
        
        // 'App\Employee'  => 'App\Policies\EmployeePolicy',
        // 'App\Order'     => 'App\Policies\OrderPolicy',
        // 'App\Product'   => 'App\Policies\ProductPolicy',
        // 'App\User'      => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
