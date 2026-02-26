<?php

declare(strict_types=1);

return [
    'testload' => [
        'users'         => env( 'TESTLOAD_USERS', 1000000 ),
        'articles'      => env( 'TESTLOAD_ARTICLES', 1000000 ),
        'landings'      => env( 'TESTLOAD_LANDINGS', 1000000 ),
        'activity_logs' => env( 'TESTLOAD_ACTIVITY_LOGS', 1000000 ),
        'roles'         => env( 'TESTLOAD_ROLES', 100 ),
    ],
];
