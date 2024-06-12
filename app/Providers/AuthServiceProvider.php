<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Route;

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
     */
    public function boot(): void
    {
        // Passport::routes();
//        Passport::routes(null, ['middleware' => [
//            'universal',
//            \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
//        ]]);
      // Passport 11.x
      Route::group([
        'as' => 'passport.',
        'middleware' => [
            'universal',
					\Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class
        ],
        'prefix' => config('passport.path', 'oauth'),
        'namespace' => 'Laravel\Passport\Http\Controllers',
      ], function () {
        $this->loadRoutesFrom(__DIR__ . "/../../vendor/laravel/passport/routes/web.php");
      });
        //
    }
}
