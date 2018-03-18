<?php

namespace App\RegisteringMembers;

use App\Mail\WelcomeUser;
use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

class SendWelcomeEmailAfterRegistration implements Consumer
{
    public function handle(Message $message)
    {
        $event = $message->event();

        if ($event instanceof RegistrationCompleted) {
            \Mail::send(new WelcomeUser($event->email(), $event->name()));
        }
    }
}