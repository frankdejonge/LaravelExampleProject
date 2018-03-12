<?php

namespace App\EventSauce;

use Enqueue\Client\Message as EnqueueMessage;
use Enqueue\SimpleClient\SimpleClient;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use function json_encode;

class LaravelMessageDispatcher implements MessageDispatcher
{
    /**
     * @var MessageSerializer
     */
    private $serializer;

    /**
     * @var SimpleClient
     */
    private $simpleClient;

    public function __construct(MessageSerializer $serializer, SimpleClient $simpleClient)
    {
        $this->serializer = $serializer;
        $this->simpleClient = $simpleClient;
    }

    public function dispatch(Message ... $messages)
    {
        foreach ($messages as $message) {
            $payload = $this->serializer->serializeMessage($message);
            $this->simpleClient->sendEvent(
                'eventsauce_messages',
                new EnqueueMessage(json_encode($payload), [], $payload['headers'])
            );
        }
    }
}