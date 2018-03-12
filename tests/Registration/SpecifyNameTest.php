<?php

namespace Tests\Registration;

use LaravelExample\Registration\NameWasSpecified;
use LaravelExample\Registration\RegistrationHasStarted;
use LaravelExample\Registration\SpecifyName;

class SpecifyNameTest extends RegistrationProcessTestCase
{
    /**
     * @test
     */
    public function specifying_a_name()
    {
        $this->given(
            new RegistrationHasStarted($this->pointInTime())
        )->when(
            new SpecifyName($this->pointInTime(), $this->aggregateRootId, 'Valid Name')
        )->then(
            new NameWasSpecified(
                $this->pointInTime(),
                'Valid Name'
            )
        );
    }
}