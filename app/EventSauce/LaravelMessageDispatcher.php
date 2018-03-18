<?php

namespace App\EventSauce;

use App\Jobs\ProcessRegistrationMessage;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;

class LaravelMessageDispatcher implements MessageDispatcher
{
    public function dispatch(Message ... $messages)
    {
        foreach ($messages as $message) {
            ProcessRegistrationMessage::dispatch($message);
        }
    }
}