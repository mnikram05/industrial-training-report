<?php

declare(strict_types=1);

namespace App\Modules\Auth\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Modules\Auth\Requests\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view( 'modules.auth.login' );
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store( LoginRequest $request ): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended( route( 'dashboard', absolute: false ) );
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy( Request $request ): RedirectResponse
    {
        Auth::guard( 'web' )->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect( '/' );
    }
}
