<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Modules\Auth\Dtos\RegisterUserDto;
use Illuminate\Http\RedirectResponse;
use App\Modules\Auth\Requests\RegisterUserRequest;
use App\Modules\Auth\Services\RegistrationService;

class RegisteredUserController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService
    ) {}

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view( 'modules.auth.register' );
    }

    /**
     * Handle an incoming registration request.
     */
    public function store( RegisterUserRequest $request ): RedirectResponse
    {
        $user = $this->registrationService->register(
            RegisterUserDto::fromArray( $request->validated() ),
        );

        event( new Registered( $user ) );

        return redirect()
            ->route( 'login' )
            ->with( 'status', __( 'modules/login.register.pending_approval' ) );
    }
}
