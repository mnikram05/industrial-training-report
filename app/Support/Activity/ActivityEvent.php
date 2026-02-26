<?php

declare(strict_types=1);

namespace App\Support\Activity;

enum ActivityEvent: string
{
    case Created           = 'created';
    case Updated           = 'updated';
    case Deleted           = 'deleted';
    case Exported          = 'exported';
    case Imported          = 'imported';
    case Published         = 'published';
    case Unpublished       = 'unpublished';
    case LoggedIn          = 'logged-in';
    case LoggedOut         = 'logged-out';
    case Impersonated      = 'impersonated';
    case ImpersonationLeft = 'impersonation-left';
}
