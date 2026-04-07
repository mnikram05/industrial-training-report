<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\User\Models\User;
use App\Modules\Role\Constants\RolePermissionConstants;
use Modules\PortalAdministration\Models\Menu;

class MenuPolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::MENUS_VIEW );
    }

    public function view( User $user, Menu $menu ): bool
    {
        return $user->can( RolePermissionConstants::MENUS_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::MENUS_CREATE );
    }

    public function update( User $user, Menu $menu ): bool
    {
        return $user->can( RolePermissionConstants::MENUS_EDIT );
    }

    public function delete( User $user, Menu $menu ): bool
    {
        return $user->can( RolePermissionConstants::MENUS_DELETE );
    }

    public function restore( User $user, Menu $menu ): bool
    {
        return $this->delete( $user, $menu );
    }

    public function forceDelete( User $user, Menu $menu ): bool
    {
        return $this->delete( $user, $menu );
    }
}
