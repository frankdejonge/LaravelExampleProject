<?php

namespace App\Providers;

use App\PasswordHasher;
use Enqueue\SimpleClient\SimpleClient;
use Illuminate\Container\Container;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\ServiceProvider;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProcessor;

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
        $this->app->singleton(PasswordHasher::class, function (Container $container) {
            return new PasswordHasher($container->make(Hasher::class));
        });

        $this->app->resolving(SimpleClient::class, function (SimpleClient $client, $app) {
            $client->bind('enqueue_test', 'a_processor', function(PsrMessage $message) {
                // do stuff here

                return PsrProcessor::ACK;
            });

            return $client;
        });
    }
}
