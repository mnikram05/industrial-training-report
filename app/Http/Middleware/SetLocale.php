<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle( Request $request, Closure $next ): Response
    {
        $locale = $request->session()->get( 'locale' );

        if ( is_string( $locale ) && in_array( $locale, ['en', 'ms'], true ) ) {
            app()->setLocale( $locale );
        }

        $response = $next( $request );

        return $response;
    }
}
