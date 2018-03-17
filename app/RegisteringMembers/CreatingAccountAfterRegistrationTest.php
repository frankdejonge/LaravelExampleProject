<?php

namespace App\RegisteringMembers;

use App\User;
use App\Users\InMemoryUserRepository;
use function compact;
use EventSauce\EventSourcing\Message;
use LaravelExample\Registration\RegistrationCompleted;
use Tests\TestCase;

class CreatingAccountAfterRegistrationTest extends TestCase
{
    /**
     * @test
     */
    public function an_account_is_created_after_completing_the_registration_process()
    {
        $repository = new InMemoryUserRepository();
        $consumer = new CreateAccountAfterRegistration($repository);
        $message = new Message(new RegistrationCompleted(
            $name = 'username',
            $email = 'info@email.me',
            $password = 'some hashed password'
        ));
        $consumer->handle($message);
        $user = $repository->findByEmail($email);
        $expectedUser = User::make(compact('name', 'email', 'password'));
        $this->assertEquals($expectedUser, $user);
    }
}