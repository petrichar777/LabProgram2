<?php

namespace App\Providers;

<<<<<<< HEAD
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
=======
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
>>>>>>> d6f3464 (first commit)
     *
     * @return void
     */
    public function boot()
    {
<<<<<<< HEAD
=======
        $this->registerPolicies();

>>>>>>> d6f3464 (first commit)
        //
    }
}
