<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use NunoMaduro\Collision\Provider;

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
        Validator::extend('filter', function($attribute, $value, $params){
            return !in_array(strtolower($value), $params);
        }, 'the value is prohippted!');

        Paginator::useBootstrap();
    }
}
