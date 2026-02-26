<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Modules\Role\Constants\RoleNameConstants;
use App\Modules\Role\Constants\RolePermissionConstants;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ( RolePermissionConstants::all() as $permission ) {
            Permission::firstOrCreate( [
                'name'       => $permission,
                'guard_name' => 'web',
            ] );
        }

        $admin = Role::firstOrCreate( [
            'name'       => RoleNameConstants::ADMIN,
            'guard_name' => 'web',
        ] );
        $admin->syncPermissions( RolePermissionConstants::forAdmin() );

        $editor = Role::firstOrCreate( [
            'name'       => RoleNameConstants::EDITOR,
            'guard_name' => 'web',
        ] );
        $editor->syncPermissions( RolePermissionConstants::forEditor() );

        $viewer = Role::firstOrCreate( [
            'name'       => RoleNameConstants::VIEWER,
            'guard_name' => 'web',
        ] );
        $viewer->syncPermissions( RolePermissionConstants::forViewer() );
    }
}
