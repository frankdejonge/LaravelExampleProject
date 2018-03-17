<?php

namespace App\RegisteringMembers;

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
            new SpecifyName($this->registrationId(), 'Valid Name')
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
            new SpecifyName($this->registrationId(), "")
        )->expectToFail(
            new SorryInvalidNameProvided
        );
    }

    /**
     * @test
     */
    public function specifying_an_name_twice()
    {
        $name = 'My Name';
        $this->given(
            NameWasSpecified::withName($name)
        )->when(
            new SpecifyName($this->registrationId(), $name)
        )->thenNothingShouldHaveHappened();
    }
}