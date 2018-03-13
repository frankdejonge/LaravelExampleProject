<?php

namespace App\RegisteringMembers;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour\AggregateRootBehaviour;
use LaravelExample\Registration\NameWasSpecified;
use LaravelExample\Registration\RegistrationHasStarted;

class RegistrationProcess implements AggregateRoot
{
    use AggregateRootBehaviour;

    public function start()
    {
        $this->recordThat(new RegistrationHasStarted());
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
}