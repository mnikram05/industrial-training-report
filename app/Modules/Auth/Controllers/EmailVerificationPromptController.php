<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke( Request $request ): RedirectResponse|View
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        return $user->hasVerifiedEmail()
                    ? redirect()->intended( route( 'dashboard', absolute: false ) )
                    : view( 'modules.auth.verify-email' );
    }
}
