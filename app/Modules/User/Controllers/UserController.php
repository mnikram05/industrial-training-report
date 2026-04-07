<?php

declare(strict_types=1);

namespace App\Modules\User\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use Illuminate\Http\JsonResponse;
use App\Modules\User\Dtos\UserDto;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Modules\User\Requests\UserRequest;
use App\Modules\User\Services\UserService;
use App\Modules\User\DataTables\UserDataTable;
use App\Support\Export\LatestCompletedExportPathResolver;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected UserDataTable $userDataTable,
        private LatestCompletedExportPathResolver $latestCompletedExportPathResolver,
    ) {
        $this->authorizeResource( User::class, 'user' );
    }

    /**
     * Display a listing of users.
     */
    public function index( Request $request ): View
    {
        $latestExportPath = $this->latestCompletedExportPathResolver->resolve( 'users', $request->user() );

        return view( 'modules.users.index', [
            'dataTable'        => $this->userDataTable,
            'latestExportPath' => $latestExportPath,
        ] );
    }

    public function data( Request $request ): JsonResponse
    {
        $this->authorize( 'viewAny', User::class );

        return $this->userDataTable->ajax();
    }

    /**
     * Show the form for creating a new user.
     */
    public function create( Request $request ): View
    {
        return view( 'modules.users.create', [
            'availableRoleOptions' => $this->userService->getAssignableRoleOptionsFor( $request->user() ),
        ] );
    }

    /**
     * Store a newly created user.
     */
    public function store( UserRequest $request ): RedirectResponse
    {
        $validated = $this->userService->sanitizeValidatedInput(
            $request->validated(),
            $request->user(),
        );

        $user = $this->userService->createUser(
            UserDto::forCreate( $validated ),
            $request->user(),
        );

        return redirect()
            ->route( 'users.edit', $user )
            ->with( 'status', 'user-created' );
    }

    /**
     * Display the specified user.
     */
    public function show( User $user ): View
    {
        return view( 'modules.users.show', [
            'user' => $user,
        ] );
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit( Request $request, User $user ): View
    {
        $user->loadMissing( 'roles' );

        return view( 'modules.users.edit', [
            'user'                 => $user,
            'availableRoleOptions' => $this->userService->getAssignableRoleOptionsFor( $request->user() ),
        ] );
    }

    /**
     * Update the specified user.
     */
    public function update( UserRequest $request, User $user ): RedirectResponse
    {
        $validated = $this->userService->sanitizeValidatedInput(
            $request->validated(),
            $request->user(),
        );

        $this->userService->updateUser(
            $user,
            UserDto::forUpdate( $validated ),
            $request->user(),
        );

        return redirect()
            ->route( 'users.edit', $user )
            ->with( 'status', 'user-updated' );
    }

    /**
     * Remove the specified user.
     */
    public function destroy( Request $request, User $user ): RedirectResponse
    {
        $this->userService->deleteUser( $user, $request->user() );

        return redirect()
            ->route( 'users.index' )
            ->with( 'status', 'user-deleted' );
    }

    public function approve( Request $request, User $user ): RedirectResponse
    {
        $this->authorize( 'approve', $user );

        $this->userService->approveSelfRegisteredUser( $user, $request->user() );

        return redirect()
            ->route( 'users.index' )
            ->with( 'status', 'user-approved' );
    }

    public function reject( Request $request, User $user ): RedirectResponse
    {
        $this->authorize( 'reject', $user );

        $this->userService->rejectSelfRegisteredUser( $user, $request->user() );

        return redirect()
            ->route( 'users.index' )
            ->with( 'status', 'user-rejected' );
    }
}
