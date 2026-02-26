<?php

declare(strict_types=1);

namespace App\Policies;

use App\Support\Status\Status;
use App\Modules\User\Models\User;
use App\Modules\Role\Constants\RolePermissionConstants;

class StatusPolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::STATUSES_VIEW );
    }

    public function view( User $user, Status $status ): bool
    {
        return $user->can( RolePermissionConstants::STATUSES_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::STATUSES_CREATE );
    }

    public function update( User $user, Status $status ): bool
    {
        return $user->can( RolePermissionConstants::STATUSES_EDIT );
    }

    public function delete( User $user, Status $status ): bool
    {
        return $user->can( RolePermissionConstants::STATUSES_DELETE );
    }
}
