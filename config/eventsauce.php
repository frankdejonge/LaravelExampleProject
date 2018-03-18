<?php

use App\RegisteringMembers\CreateAccountAfterRegistration;
use App\RegisteringMembers\RegistrationProcess;
use App\RegisteringMembers\SendWelcomeEmailAfterRegistration;

return [
    'aggregate_root' => RegistrationProcess::class,
    'sync_consumers' => [
        CreateAccountAfterRegistration::class,
    ],
    'async_consumers' => [
        SendWelcomeEmailAfterRegistration::class,
    ],
    'definition' => __DIR__.'/../app/RegisteringMembers/commands-and-events.yml',
    'output' => __DIR__.'/../app/RegisteringMembers/commands-and-events.php',
];