<?php

namespace App\RegisteringMembers;

class ConfirmRegistrationTest extends RegistrationProcessTestCase
{
    /**
     * @test
     */
    public function confirming_registration()
    {
        $name = 'Frank de Jonge';
        $email = 'some@email.nl';
        $password = 'some secure passw0rd';
        $hashedPassword = $this->passwordHasher->hash($password);

        $this->given(
            RegistrationHasStarted::with(),
            NameWasSpecified::withName($name),
            EmailWasSpecified::withEmail($email),
            PasswordWasSpecified::withPasswordHash($hashedPassword)
        )->when(
            new ConfirmRegistration($this->registrationId())
        )->then(
            new RegistrationCompleted($name, $email, $hashedPassword)
        );
    }

    /**
     * @test
     */
    public function confirming_without_a_password()
    {
        $name = 'Frank de Jonge';
        $email = 'some@email.nl';

        $this->given(
            RegistrationHasStarted::with(),
            NameWasSpecified::withName($name),
            EmailWasSpecified::withEmail($email)
        )->when(
            new ConfirmRegistration($this->registrationId())
        )->expectToFail(SorryRegistrationIsIncomplete::missingPassword());
    }

    /**
     * @test
     */
    public function confirming_without_an_email()
    {
        $name = 'Frank de Jonge';
        $password = 'some secure passw0rd';
        $hashedPassword = $this->passwordHasher->hash($password);

        $this->given(
            RegistrationHasStarted::with(),
            NameWasSpecified::withName($name),
            PasswordWasSpecified::withPasswordHash($hashedPassword)
        )->when(
            new ConfirmRegistration($this->registrationId())
        )->expectToFail(SorryRegistrationIsIncomplete::missingEmail());
    }

    /**
     * @test
     */
    public function confirming_without_a_name()
    {
        $email = 'some@email.nl';
        $password = 'some secure passw0rd';
        $hashedPassword = $this->passwordHasher->hash($password);

        $this->given(
            RegistrationHasStarted::with(),
            EmailWasSpecified::withEmail($email),
            PasswordWasSpecified::withPasswordHash($hashedPassword)
        )->when(
            new ConfirmRegistration($this->registrationId())
        )->expectToFail(SorryRegistrationIsIncomplete::missingName());
    }
}