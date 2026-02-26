<?php

declare(strict_types=1);

namespace App\Modules\Role\Services;

use App\Modules\Role\Dtos\RoleDto;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Support\Activity\Concerns\LogsModuleCrudActivity;

class RoleService
{
    use LogsModuleCrudActivity;

    private const LOG_NAME = 'roles';

    private const RESOURCE_LABEL = 'Role';

    /**
     * @return array<int, string>
     */
    public function getAvailablePermissionNames(): array
    {
        return Permission::query()
            ->orderBy( 'name' )
            ->pluck( 'name' )
            ->filter( static fn ( mixed $permission ): bool => is_string( $permission ) && $permission !== '' )
            ->values()
            ->all();
    }

    /**
     * Create a role.
     */
    public function createRole( RoleDto $data, ?Authenticatable $causer = null ): Role
    {
        $role             = new Role;
        $role->name       = $data->name;
        $role->guard_name = 'web';
        $role->save();
        $role->syncPermissions( $data->permissions );

        $this->logCreateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $role );

        return $role;
    }

    /**
     * Update a role.
     */
    public function updateRole( Role $role, RoleDto $data, ?Authenticatable $causer = null ): Role
    {
        $role->update( [
            'name' => $data->name,
        ] );
        $role->syncPermissions( $data->permissions );

        $role = $role->refresh();

        $this->logUpdateAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $role );

        return $role;
    }

    /**
     * Delete a role.
     */
    public function deleteRole( Role $role, ?Authenticatable $causer = null ): bool
    {
        $deleted = (bool) $role->delete();

        if ( $deleted ) {
            $this->logDeleteAction( self::LOG_NAME, self::RESOURCE_LABEL, $causer, $role );
        }

        return $deleted;
    }
}
