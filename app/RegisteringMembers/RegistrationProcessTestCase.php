<?php

namespace App\RegisteringMembers;

use App\PasswordHasher;
use App\TestPasswordHasher;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\AggregateRootTestCase;
use EventSauce\EventSourcing\UuidAggregateRootId;

abstract class RegistrationProcessTestCase extends AggregateRootTestCase
{
    /**
     * @var PasswordHasher
     */
    protected $passwordHasher;

    /**
     * @before
     */
    public function setupServices()
    {
        $this->passwordHasher = new PasswordHasher(new TestPasswordHasher());
    }

    protected function newAggregateRootId(): AggregateRootId
    {
        return UuidAggregateRootId::create();
    }

    protected function aggregateRootClassName(): string
    {
        return RegistrationProcess::class;
    }

    public function registrationId(): UuidAggregateRootId
    {
        return $this->aggregateRootId();
    }

    protected function handle($command)
    {
        (new RegistrationCommandHandler(
            $this->repository,
            $this->passwordHasher
        ))->handle($command);
    }
}