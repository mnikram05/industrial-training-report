<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\User\Models\User;
use App\Modules\Role\Constants\RolePermissionConstants;

class UserPolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::USERS_VIEW );
    }

    public function view( User $user, User $model ): bool
    {
        return $user->can( RolePermissionConstants::USERS_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::USERS_CREATE );
    }

    public function update( User $user, User $model ): bool
    {
        return $user->can( RolePermissionConstants::USERS_EDIT );
    }

    public function delete( User $user, User $model ): bool
    {
        return $user->can( RolePermissionConstants::USERS_DELETE );
    }
}
