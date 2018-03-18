<?php

namespace App\Providers;

use App\EventSauce\LaravelMessageDispatcher;
use App\EventSauce\LaravelMessageRepository;
use App\Jobs\ProcessRegistrationMessage;
use App\PasswordHasher;
use App\RegisteringMembers\RegistrationCommandHandler;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\MessageDispatcherChain;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use function array_map;
use function config;

class EventSauceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(RegistrationCommandHandler::class, function (Container $app) {
            return new RegistrationCommandHandler(
                $app->make(AggregateRootRepository::class),
                $app->make(PasswordHasher::class)
            );
        });

        $this->app->bind(MessageSerializer::class, function () {
            return new ConstructingMessageSerializer();
        });

        $this->app->bind(AggregateRootRepository::class, function (Container $app) {
            $asyncDispatcher = null;

            if ( ! empty(config('eventsauce.async_consumers'))) {
                $asyncDispatcher = $app->make(LaravelMessageDispatcher::class);
            }

            return new AggregateRootRepository(
                config('eventsauce.aggregate_root'),
                $app->make(LaravelMessageRepository::class),
                new MessageDispatcherChain(
                    $asyncDispatcher,
                    $app->make(SynchronousMessageDispatcher::class)
                )
            );
        });

        $this->app->bind(SynchronousMessageDispatcher::class, function (Container $app) {
            $consumers = array_map(function ($consumerName) use ($app) {
                return $app->make($consumerName);
            }, config('eventsauce.sync_consumers'));

            return new SynchronousMessageDispatcher(... $consumers);
        });

        $this->app->bind('eventsauce.async_dispatcher', function (Container $container) {
            $consumers = array_map(function ($consumerName) use ($container) {
                return $container->make($consumerName);
            }, config('eventsauce.async_consumers'));

            return new SynchronousMessageDispatcher(... $consumers);
        });

        $this->app->bindMethod(ProcessRegistrationMessage::class.'@handle', function (ProcessRegistrationMessage $job, Container $container) {
            $dispatcher = $container->make('eventsauce.async_dispatcher');

            return $job->handle($dispatcher);
        });
    }
}