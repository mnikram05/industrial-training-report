<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update( Request $request ): RedirectResponse
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        /** @var array{current_password: string, password: string, password_confirmation: string} $validated */
        $validated = $request->validateWithBag( 'updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', Password::defaults(), 'confirmed'],
        ] );

        $user->storePassword( $validated['password'] );

        return back()->with( 'status', 'password-updated' );
    }
}
