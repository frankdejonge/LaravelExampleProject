<?php

namespace Tests\Registration;

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
            new StartRegistration($this->aggregateRootId)
        )->then(
            new RegistrationHasStarted()
        );
    }
}