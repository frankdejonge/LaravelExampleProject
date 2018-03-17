<?php

namespace App\RegisteringMembers;

use LaravelExample\Registration\RegistrationHasStarted;
use LaravelExample\Registration\StartRegistration;

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