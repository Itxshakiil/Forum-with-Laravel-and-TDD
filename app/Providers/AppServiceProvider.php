<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Validator;
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
     *
     * @return void
     */
    public function boot()
    {
        \view()->composer('threads.create', function ($view) {
            $view->with('channels', Channel::all());
        });

        Validator::extend('spamfree', 'App\Rules\SpamFree@passes', 'The :attribute contains spam.');
    }
}
