<?php

namespace App\RegisteringMembers;

use App\User;
use App\Users\UserRepository;
use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

class CreateAccountAfterRegistration implements Consumer
{
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function handle(Message $message)
    {
        $event = $message->event();

        if ($event instanceof RegistrationCompleted) {
            /** @var User $user */
            $user = User::make([
                'name'     => $event->name(),
                'email'    => $event->email(),
                'password' => $event->passwordHash(),
            ]);
            $this->users->store($user);
        }
    }
}