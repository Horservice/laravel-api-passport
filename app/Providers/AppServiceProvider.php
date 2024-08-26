<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Passport::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //    Passport::tokensExpireIn(now()->addDays(15));
        //    Passport::refreshTokensExpireIn(now()->addDays(30));
        //    Passport::personalAccessTokensExpireIn(now()->addMonths(6));
           Passport::tokensCan([
               'get-email' => 'Retrieve the email associated with your account',
               'create-posts' => 'Create posts on behalf of your user',
           ]);

    }
}
