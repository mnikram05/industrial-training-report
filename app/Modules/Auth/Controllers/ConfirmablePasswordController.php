<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view( 'modules.auth.confirm-password' );
    }

    /**
     * Confirm the user's password.
     */
    public function store( Request $request ): RedirectResponse
    {
        $user = $request->user();

        if ( ! $user instanceof User ) {
            abort( 403 );
        }

        if ( ! Auth::guard( 'web' )->validate( [
            'email'    => $user->email,
            'password' => $request->string( 'password' )->toString(),
        ] ) ) {
            throw ValidationException::withMessages( [
                'password' => __( 'auth.password' ),
            ] );
        }

        $request->session()->put( 'auth.password_confirmed_at', time() );

        return redirect()->intended( route( 'dashboard', absolute: false ) );
    }
}
