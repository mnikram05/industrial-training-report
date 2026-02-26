<?php

declare(strict_types=1);

namespace App\Modules\Role\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Modules\Role\Dtos\RoleDto;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Modules\Role\Requests\RoleRequest;
use App\Modules\Role\Services\RoleService;
use App\Modules\Role\DataTables\RoleDataTable;
use App\Support\Export\LatestCompletedExportPathResolver;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService,
        protected RoleDataTable $roleDataTable,
        private LatestCompletedExportPathResolver $latestCompletedExportPathResolver,
    ) {
        $this->authorizeResource( Role::class, 'role' );
    }

    /**
     * Display a listing of roles.
     */
    public function index( Request $request ): JsonResponse|View
    {
        if ( $request->ajax() ) {
            return $this->roleDataTable->ajax();
        }

        $latestExportPath = $this->latestCompletedExportPathResolver->resolve( 'roles', $request->user() );

        return view( 'modules.roles.index', [
            'dataTable'        => $this->roleDataTable,
            'latestExportPath' => $latestExportPath,
        ] );
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        return view( 'modules.roles.create', [
            'availablePermissions' => $this->roleService->getAvailablePermissionNames(),
            'selectedPermissions'  => [],
        ] );
    }

    /**
     * Store a newly created role.
     */
    public function store( RoleRequest $request ): RedirectResponse
    {
        $role = $this->roleService->createRole(
            RoleDto::fromArray( $request->validated() ),
            $request->user(),
        );

        return redirect()
            ->route( 'roles.edit', $role )
            ->with( 'status', 'role-created' );
    }

    /**
     * Display the specified role.
     */
    public function show( Role $role ): View
    {
        return view( 'modules.roles.show', [
            'role' => $role,
        ] );
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit( Role $role ): View
    {
        $role->loadMissing( 'permissions' );

        return view( 'modules.roles.edit', [
            'role'                 => $role,
            'availablePermissions' => $this->roleService->getAvailablePermissionNames(),
            'selectedPermissions'  => $role->permissions->pluck( 'name' )->all(),
        ] );
    }

    /**
     * Update the specified role.
     */
    public function update( RoleRequest $request, Role $role ): RedirectResponse
    {
        $this->roleService->updateRole(
            $role,
            RoleDto::fromArray( $request->validated() ),
            $request->user(),
        );

        return redirect()
            ->route( 'roles.edit', $role )
            ->with( 'status', 'role-updated' );
    }

    /**
     * Remove the specified role.
     */
    public function destroy( Request $request, Role $role ): RedirectResponse
    {
        $this->roleService->deleteRole( $role, $request->user() );

        return redirect()
            ->route( 'roles.index' )
            ->with( 'status', 'role-deleted' );
    }
}
