<?php

namespace Tests\Registration;

use App\RegisteringMembers\SorryInvalidNameProvided;
use LaravelExample\Registration\NameWasSpecified;
use LaravelExample\Registration\RegistrationHasStarted;
use LaravelExample\Registration\SpecifyName;

class SpecifyNameTest extends RegistrationProcessTestCase
{
    /**
     * @before
     */
    public function preconditions()
    {
        $this->given(new RegistrationHasStarted());
    }

    /**
     * @test
     */
    public function specifying_a_name()
    {
        $this->when(
            new SpecifyName($this->aggregateRootId, 'Valid Name')
        )->then(
            new NameWasSpecified('Valid Name')
        );
    }

    /**
     * @test
     */
    public function specifying_an_invalid_name()
    {
        $this->when(
            new SpecifyName($this->aggregateRootId, "")
        )->expectToFail(
            new SorryInvalidNameProvided
        );
    }
}