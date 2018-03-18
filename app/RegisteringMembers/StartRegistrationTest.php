<?php

namespace App\RegisteringMembers;

class StartRegistrationTest extends RegistrationProcessTestCase
{
    /**
     * @test
     */
    public function starting_registration()
    {
        $this->when(
            new StartRegistration($this->registrationId())
        )->then(
            new RegistrationHasStarted()
        );
    }
}