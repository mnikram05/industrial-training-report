<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Modules\Auth\Dtos\AccountProfileDto;
use App\Modules\Auth\Services\AccountService;
use App\Modules\Auth\Requests\AccountUpdateRequest;

class AccountController extends Controller
{
    public function __construct(
        protected AccountService $accountService
    ) {}

    /**
     * Display the account settings page.
     */
    public function edit( Request $request ): View
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        return view( 'modules.auth.account', [
            'monthlyLoginActivityData' => $this->accountService->getLoginActivityByMonth( $user ),
        ] );
    }

    /**
     * Update the authenticated user's profile information.
     */
    public function update( AccountUpdateRequest $request ): RedirectResponse
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        $this->accountService->updateProfile(
            $user,
            AccountProfileDto::fromArray( $request->validated() ),
        );

        return back()->with( 'status', 'profile-updated' );
    }

    /**
     * Remove the authenticated user's account.
     */
    public function destroy( Request $request ): RedirectResponse
    {
        $request->validateWithBag( 'accountDeletion', [
            'password' => ['required', 'current_password'],
        ] );

        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        Auth::logout();

        $this->accountService->deleteAccount( $user );

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route( 'home' );
    }
}
