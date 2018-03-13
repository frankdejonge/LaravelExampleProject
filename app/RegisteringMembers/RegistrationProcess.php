<?php

namespace App\RegisteringMembers;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour\AggregateRootBehaviour;
use LaravelExample\Registration\EmailWasSpecified;
use LaravelExample\Registration\NameWasSpecified;
use LaravelExample\Registration\RegistrationHasStarted;
use function preg_match;
use function var_dump;

class RegistrationProcess implements AggregateRoot
{
    use AggregateRootBehaviour;

    /**
     * @var string
     */
    private $email;

    public function start()
    {
        $this->recordThat(new RegistrationHasStarted());
    }

    public function specify(string $email)
    {
        $this->guardAgainstInvalidEmail($email);

        if ($this->email !== $email) {
            $this->recordThat(new EmailWasSpecified($email));
        }
    }

    protected function applyEmailWasSpecified(EmailWasSpecified $event)
    {
        $this->email = $event->email();
    }

    protected function applyRegistrationHasStarted(RegistrationHasStarted $event)
    {
        //
    }

    public function specifyName(string $name)
    {
        $this->guardAgainstInvalidName($name);

        $this->recordThat(new NameWasSpecified(
            $name
        ));
    }

    protected function applyNameWasSpecified(NameWasSpecified $event)
    {

    }

    private function guardAgainstInvalidName(string $name)
    {
        if (empty($name)) {
            throw new SorryInvalidNameProvided;
        }
    }

    private function guardAgainstInvalidEmail($email)
    {
        if (preg_match('~^.*@.*\..*$~', $email) !== 1) {
            throw new SorryInvalidEmailProvided();
        }
    }
}