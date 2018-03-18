<?php

namespace App\RegisteringMembers;

class SpecifyEmailTest extends RegistrationProcessTestCase
{
    /**
     * @before
     */
    public function preconditions()
    {
        $this->given(
            new RegistrationHasStarted(),
            NameWasSpecified::withName('First Last')
        );
    }

    /**
     * @test
     */
    public function specifying_a_email()
    {
        $this->when(
            new SpecifyEmail($this->registrationId(), 'valid@email.com')
        )->then(
            new EmailWasSpecified('valid@email.com')
        );
    }

    /**
     * @test
     */
    public function specifying_an_invalid_email()
    {
        $this->when(
            new SpecifyEmail($this->registrationId(), "not valid email")
        )->expectToFail(
            new SorryInvalidEmailProvided
        );
    }

    /**
     * @test
     */
    public function specifying_emails_is_idempotent()
    {
        $this->given(
            new EmailWasSpecified('valid@email.com')
        )->when(
            new SpecifyEmail($this->registrationId(), 'valid@email.com')
        )
            ->thenNothingShouldHaveHappened();
    }
}