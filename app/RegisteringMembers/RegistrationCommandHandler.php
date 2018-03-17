<?php

namespace App\RegisteringMembers;

use App\PasswordHasher;
use EventSauce\EventSourcing\AggregateRootRepository;
use LaravelExample\Registration\ConfirmRegistration;
use LaravelExample\Registration\SpecifyEmail;
use LaravelExample\Registration\SpecifyName;
use LaravelExample\Registration\SpecifyPassword;
use LaravelExample\Registration\StartRegistration;

class RegistrationCommandHandler
{
    /**
     * @var AggregateRootRepository
     */
    private $repository;

    /**
     * @var PasswordHasher
     */
    private $passwordHasher;

    public function __construct(
        AggregateRootRepository $repository,
        PasswordHasher $passwordHasher
    ) {
        $this->repository = $repository;
        $this->passwordHasher = $passwordHasher;
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
            } elseif ($command instanceof SpecifyEmail) {
                $registrationProcess->specifyEmail($command->email());
            } elseif ($command instanceof SpecifyPassword) {
                $registrationProcess->specifyPassword(
                    $this->passwordHasher,
                    $command->password(),
                    $command->verificationPassword()
                );
            } elseif ($command instanceof ConfirmRegistration) {
                $registrationProcess->confirmRegistration();
            }
        } finally {
            $this->repository->persist($registrationProcess);
        }
    }
}