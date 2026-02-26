<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use App\Modules\Role\Constants\RolePermissionConstants;

class RolePolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::ROLES_VIEW );
    }

    public function view( User $user, Role $role ): bool
    {
        return $user->can( RolePermissionConstants::ROLES_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::ROLES_CREATE );
    }

    public function update( User $user, Role $role ): bool
    {
        return $user->can( RolePermissionConstants::ROLES_EDIT );
    }

    public function delete( User $user, Role $role ): bool
    {
        return $user->can( RolePermissionConstants::ROLES_DELETE );
    }
}
