<?php

namespace App\RegisteringMembers;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour\AggregateRootBehaviour;
use EventSauce\EventSourcing\Time\Clock;
use LaravelExample\Registration\NameWasSpecified;
use LaravelExample\Registration\RegistrationHasStarted;

class RegistrationProcess implements AggregateRoot
{
    use AggregateRootBehaviour;

    public function start(Clock $clock)
    {
        $this->recordThat(new RegistrationHasStarted(
            $clock->pointInTime()
        ));
    }

    protected function applyRegistrationHasStarted(RegistrationHasStarted $event)
    {
        //
    }

    public function specifyName(Clock $clock, string $name)
    {
        $this->guardAgainstInvalidName($name);

        $this->recordThat(new NameWasSpecified(
            $clock->pointInTime(),
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