<?php

namespace App\RegisteringMembers;

class SpecifyPasswordTest extends RegistrationProcessTestCase
{
    /**
     * @before
     */
    public function preconditions()
    {
        $this->given(
            RegistrationHasStarted::with(),
            NameWasSpecified::withName('Frank de Jonge'),
            EmailWasSpecified::withEmail('me@hahaha.nl')
        );
    }

    /**
     * @test
     */
    public function specifying_a_password()
    {
        $this->when(new SpecifyPassword(
            $this->registrationId(),
            $password = 'A very s3c4r3 p@ssword',
            $password
        ))->then(
            new PasswordWasSpecified(
                $this->passwordHasher->hash($password)
            )
        );
    }

    /**
     * @test
     */
    public function specifying_an_insecure_password()
    {
        $this->when(new SpecifyPassword(
            $this->registrationId(),
            $password = 'short',
            $password
        ))->expectToFail(new SorryPasswordIsInsecure());
    }

    /**
     * @test
     */
    public function failing_password_verification()
    {
        $this->when(new SpecifyPassword(
            $this->registrationId(),
            'a valid secure password',
            'another very valid password 1234'
        ))->expectToFail(new SorryPasswordVerificationFailed());
    }
}