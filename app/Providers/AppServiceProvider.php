<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user) {
            // if ($user->super_admin === 1) {
                return true;
            // }
        });

        foreach (config('abilities') as $ability_name => $ability_value) {
            Gate::define($ability_value, function ($user) use ($ability_value) {
                return $user->hasAbility($ability_value);
            });
        }
    }

}
