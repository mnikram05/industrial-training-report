<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use App\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke( EmailVerificationRequest $request ): RedirectResponse
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        if ( $user->hasVerifiedEmail() ) {
            return redirect()->intended( route( 'dashboard', absolute: false ) . '?verified=1' );
        }

        if ( $user->markEmailAsVerified() ) {
            event( new Verified( $user ) );
        }

        return redirect()->intended( route( 'dashboard', absolute: false ) . '?verified=1' );
    }
}
