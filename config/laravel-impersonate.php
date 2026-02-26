<?php

declare(strict_types=1);

return [
    /*
     * The session key used to store the original user id.
     */
    'session_key' => 'impersonated_by',

    /*
     * The session key used to stored the original user guard.
     */
    'session_guard' => 'impersonator_guard',

    /*
     * The session key used to stored what guard is impersonator using.
     */
    'session_guard_using' => 'impersonator_guard_using',

    /*
     * The default impersonator guard used.
     */
    'default_impersonator_guard' => 'web',

    /*
     * Redirect route / URI after taking impersonation.
     */
    'take_redirect_to' => 'dashboard',

    /*
     * Redirect route / URI after leaving impersonation.
     */
    'leave_redirect_to' => 'dashboard',
];
