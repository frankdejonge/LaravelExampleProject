<?php

namespace App\Providers;

use App\EventSauce\LaravelMessageDispatcher;
use App\EventSauce\LaravelMessageRepository;
use function array_map;
use function config;
use Enqueue\SimpleClient\SimpleClient;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\MessageDispatcherChain;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Interop\Queue\PsrMessage;
use Interop\Queue\PsrProcessor;
use function json_decode;
use Throwable;

class EventSauceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AggregateRootRepository::class, function (Container $app) {
            return new AggregateRootRepository(
                config('eventsauce.aggregate_root'),
                $app->make(LaravelMessageRepository::class),
                new MessageDispatcherChain(
                    $app->make(LaravelMessageDispatcher::class),
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

        $this->app->resolving(SimpleClient::class, function (SimpleClient $client, Container $app) {
            $consumers = array_map(function ($consumerName) use ($app) {
                return $app->make($consumerName);
            }, config('eventsauce.async_consumers'));
            $dispatcher = new SynchronousMessageDispatcher(... $consumers);
            /** @var MessageSerializer $serializer */
            $serializer = $app[MessageSerializer::class];
            $client->bind('eventsauce_messages', 'eventsauce_processor', function (PsrMessage $message) use ($dispatcher, $serializer) {
                try {
                    $messages = $serializer->unserializePayload(json_decode($message->getBody(), true));

                    foreach ($messages as $message) {
                        $dispatcher->dispatch($message);
                    }

                    return PsrProcessor::ACK;
                } catch (Throwable $exception) {
                    return PsrProcessor::REJECT;
                }
            });
        });
    }
}