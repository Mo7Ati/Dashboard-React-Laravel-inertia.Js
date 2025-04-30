<?php

namespace App\Providers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {

        Gate::before(function ($user) {
            if ($user->super_admin === 1) {
                return true;
            }
        });

        foreach (config('abilities') as $ability) {
            Gate::define($ability, function ($user) use ($ability) {
                return $user->hasAbility($ability);
            });
        }
    }

}
