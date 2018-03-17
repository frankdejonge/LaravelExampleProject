<?php

use App\RegisteringMembers\CreateAccountAfterRegistration;
use App\RegisteringMembers\RegistrationProcess;

return [
    'aggregate_root' => RegistrationProcess::class,
    'sync_consumers' => [
        CreateAccountAfterRegistration::class,
    ],
    'async_consumers' => [],
    'definition' => __DIR__.'/../app/RegisteringMembers/commands-and-events.yml',
    'output' => __DIR__.'/../app/RegisteringMembers/commands-and-events.php',
];