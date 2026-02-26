<?php

declare(strict_types=1);

namespace App\Modules\Role\Imports;

use App\Contracts\Importable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\LazyCollection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Support\Import\Concerns\InteractsWithXlsxRows;

class RoleImport implements Importable
{
    use InteractsWithXlsxRows;

    private const CHUNK_SIZE = 1_000;

    public function import( string $filePath, string|int|null $initiatedBy = null ): void
    {
        DB::disableQueryLog();

        $this->rows( $filePath )
            ->chunk( self::CHUNK_SIZE )
            ->each( function ( LazyCollection $chunk ): void {
                $rolesByName      = [];
                $permissionsByRow = [];
                $permissionNames  = [];
                $now              = now();

                foreach ( $chunk as $row ) {
                    $name = $this->value( $row, 'name' );

                    if ( $name === null ) {
                        continue;
                    }

                    $rolesByName[$name] = [
                        'name'       => $name,
                        'guard_name' => 'web',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $permissionsValue = $this->value( $row, 'permissions' );

                    if ( $permissionsValue === null ) {
                        $permissionsByRow[] = ['role_name' => $name, 'permissions' => null];

                        continue;
                    }

                    $permissions = array_values( array_filter( array_map(
                        static fn ( string $permission ): string => trim( $permission ),
                        explode( ',', $permissionsValue ),
                    ) ) );

                    $permissionsByRow[] = ['role_name' => $name, 'permissions' => $permissions];

                    foreach ( $permissions as $permission ) {
                        $permissionNames[$permission] = true;
                    }
                }

                if ( $rolesByName === [] ) {
                    return;
                }

                Role::query()->upsert(
                    array_values( $rolesByName ),
                    ['name', 'guard_name'],
                    ['updated_at'],
                );

                /** @var array<string, int> $existingRoleIds */
                /** @var array<string, int> $existingRoleIds */
                $existingRoleIds = Role::query()
                    ->where( 'guard_name', 'web' )
                    ->whereIn( 'name', array_keys( $rolesByName ) )
                    ->pluck( 'id', 'name' )
                    ->all();

                $existingPermissionIds = [];

                if ( $permissionNames !== [] ) {
                    /** @var array<string, int> $existingPermissionIds */
                    $existingPermissionIds = Permission::query()
                        ->whereIn( 'name', array_keys( $permissionNames ) )
                        ->pluck( 'id', 'name' )
                        ->all();
                }

                $roleHasPermissionsTable = config( 'permission.table_names.role_has_permissions' );

                if ( ! is_string( $roleHasPermissionsTable ) || $roleHasPermissionsTable === '' ) {
                    return;
                }

                foreach ( $permissionsByRow as $permissionRow ) {
                    $roleName = $permissionRow['role_name'];

                    if ( ! array_key_exists( $roleName, $existingRoleIds ) ) {
                        continue;
                    }

                    $permissionList = $permissionRow['permissions'] ?? null;

                    if ( ! is_array( $permissionList ) || $permissionList === [] ) {
                        continue;
                    }

                    $roleId = $existingRoleIds[$roleName];

                    DB::table( $roleHasPermissionsTable )
                        ->where( 'role_id', $roleId )
                        ->delete();

                    $rolePermissionRows = [];

                    foreach ( $permissionList as $permissionName ) {
                        if ( ! isset( $existingPermissionIds[$permissionName] ) ) {
                            continue;
                        }

                        $rolePermissionRows[] = [
                            'permission_id' => (int) $existingPermissionIds[$permissionName],
                            'role_id'       => (int) $roleId,
                        ];
                    }

                    if ( $rolePermissionRows === [] ) {
                        continue;
                    }

                    DB::table( $roleHasPermissionsTable )->insertOrIgnore( $rolePermissionRows );
                }
            } );

        app( PermissionRegistrar::class )->forgetCachedPermissions();
    }
}
