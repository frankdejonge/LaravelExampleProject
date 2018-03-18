<?php

namespace App\Jobs;

use App\EventSauce\LaravelMessageDispatcher;
use function dump;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ProcessRegistrationMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * @var Message[]
     */
    private $messages = [];

    public function __construct(Message ...$messages)
    {
        $this->messages = $messages;
    }

    public function handle(MessageDispatcher $dispatcher)
    {
        $dispatcher->dispatch(...$this->messages);
    }
}
