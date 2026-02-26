<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\User\Models\User;
use App\Modules\Landing\Models\Landing;
use App\Modules\Role\Constants\RolePermissionConstants;

class LandingPolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::LANDINGS_VIEW );
    }

    public function view( User $user, Landing $landing ): bool
    {
        return $user->can( RolePermissionConstants::LANDINGS_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::LANDINGS_CREATE );
    }

    public function update( User $user, Landing $landing ): bool
    {
        return $user->can( RolePermissionConstants::LANDINGS_EDIT );
    }

    public function delete( User $user, Landing $landing ): bool
    {
        return $user->can( RolePermissionConstants::LANDINGS_DELETE );
    }
}
