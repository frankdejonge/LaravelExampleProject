<?php

namespace App\RegisteringMembers;

use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\Time\Clock;
use LaravelExample\Registration\SpecifyName;
use LaravelExample\Registration\StartRegistration;

class RegistrationCommandHandler
{
    /**
     * @var AggregateRootRepository
     */
    private $repository;

    /**
     * @var Clock
     */
    private $clock;

    public function __construct(AggregateRootRepository $repository, Clock $clock)
    {
        $this->repository = $repository;
        $this->clock = $clock;
    }

    public function handle($command)
    {
        /** @var RegistrationProcess $registrationProcess */
        $registrationProcess = $this->repository->retrieve($command->registrationId());

        try {
            if ($command instanceof StartRegistration) {
                $registrationProcess->start();
            } elseif ($command instanceof SpecifyName) {
                $registrationProcess->specifyName($command->name());
            }
        } finally {
            $this->repository->persist($registrationProcess);
        }
    }
}