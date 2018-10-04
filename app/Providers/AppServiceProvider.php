<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('\Devio\Pipedrive\Pipedrive', function ($app) {
            return \Devio\Pipedrive\Pipedrive::OAuth([
                'clientId' => env('PIPEDRIVE_CLIENT_ID'),
                'clientSecret' => env('PIPEDRIVE_CLIENT_SECRET'),
                'redirectUrl' => env('PIPEDRIVE_REDIRECT_URI'),
                'storage' => new \App\PipedriveTokenIO()
            ]);
        });
    }
}
