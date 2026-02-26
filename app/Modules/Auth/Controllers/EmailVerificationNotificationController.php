<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store( Request $request ): RedirectResponse
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        if ( $user->hasVerifiedEmail() ) {
            return redirect()->intended( route( 'dashboard', absolute: false ) );
        }

        $user->sendEmailVerificationNotification();

        return back()->with( 'status', 'verification-link-sent' );
    }
}
