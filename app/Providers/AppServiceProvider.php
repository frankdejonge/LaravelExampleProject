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
        $this->app->resolving(SimpleClient::class, function (SimpleClient $client, $app) {
            $client->bind('enqueue_test', 'a_processor', function(PsrMessage $message) {
                // do stuff here

                return PsrProcessor::ACK;
            });

            return $client;
        });
    }
}
