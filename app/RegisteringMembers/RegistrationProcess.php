<?php

namespace App\RegisteringMembers;

use App\PasswordHasher;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour\AggregateRootBehaviour;
use LaravelExample\Registration\EmailWasSpecified;
use LaravelExample\Registration\NameWasSpecified;
use LaravelExample\Registration\PasswordWasSpecified;
use LaravelExample\Registration\RegistrationCompleted;
use LaravelExample\Registration\RegistrationHasStarted;
use function mb_strlen;
use function preg_match;

class RegistrationProcess implements AggregateRoot
{
    use AggregateRootBehaviour;

    /**
     * @var ?string
     */
    private $email;

    /**
     * @var ?string
     */
    private $name;

    /**
     * @var ?string
     */
    private $passwordHash;

    public function start()
    {
        $this->recordThat(new RegistrationHasStarted());
    }

    public function specifyPassword(PasswordHasher $passwordHasher, string $password, $passwordVerification)
    {
        $this->guardAgainstInsecurePassword($password);
        $this->passwordMustMatchVerification($password, $passwordVerification);
        $this->recordThat(new PasswordWasSpecified($passwordHasher->hash($password)));
    }

    protected function applyPasswordWasSpecified(PasswordWasSpecified $event)
    {
        $this->passwordHash = $event->passwordHash();
    }

    private function guardAgainstInsecurePassword(string $password)
    {
        if (mb_strlen($password) < 6) {
            throw new SorryPasswordIsInsecure();
        }
    }

    private function passwordMustMatchVerification(string $password, string $passwordVerification)
    {
        if ($password !== $passwordVerification) {
            throw new SorryPasswordVerificationFailed;
        }
    }

    protected function applyRegistrationHasStarted(RegistrationHasStarted $event)
    {
        //
    }

    public function specifyEmail(string $email)
    {
        $this->guardAgainstInvalidEmail($email);

        if ($this->email !== $email) {
            $this->recordThat(new EmailWasSpecified($email));
        }
    }

    private function guardAgainstInvalidEmail($email)
    {
        if (preg_match('~^.*@.*\..*$~', $email) !== 1) {
            throw new SorryInvalidEmailProvided();
        }
    }

    protected function applyEmailWasSpecified(EmailWasSpecified $event)
    {
        $this->email = $event->email();
    }

    public function specifyName(string $name)
    {
        if ($this->name === $name) {
            return;
        }

        $this->guardAgainstInvalidName($name);
        $this->recordThat(new NameWasSpecified($name));
    }

    private function guardAgainstInvalidName(string $name)
    {
        if (empty($name)) {
            throw new SorryInvalidNameProvided;
        }
    }

    protected function applyNameWasSpecified(NameWasSpecified $event)
    {
        $this->name = $event->name();
    }

    public function confirmRegistration()
    {
        $this->guardAgainstIncompleteRegistration();

        $this->recordThat(new RegistrationCompleted(
            $this->name,
            $this->email,
            $this->passwordHash
        ));
    }

    protected function applyRegistrationCompleted(RegistrationCompleted $event)
    {
        // YAY!
    }

    private function guardAgainstIncompleteRegistration()
    {
        if (empty($this->name)) {
            throw SorryRegistrationIsIncomplete::missingName();
        } elseif (empty($this->email)) {
            throw SorryRegistrationIsIncomplete::missingEmail();
        } elseif (empty($this->passwordHash)) {
            throw SorryRegistrationIsIncomplete::missingPassword();
        }
    }
}