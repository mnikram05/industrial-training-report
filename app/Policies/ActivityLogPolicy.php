<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\User\Models\User;
use Spatie\Activitylog\Models\Activity;
use App\Modules\Role\Constants\RolePermissionConstants;

class ActivityLogPolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::ACTIVITY_LOGS_VIEW );
    }

    public function view( User $user, Activity $activity ): bool
    {
        return $user->can( RolePermissionConstants::ACTIVITY_LOGS_VIEW );
    }
}
