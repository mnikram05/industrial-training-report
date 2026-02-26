<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

Route::post( 'locale', function ( Request $request ) {
    /** @var array{locale: string} $validated */
    $validated = $request->validate( [
        'locale' => ['required', 'string', Rule::in( ['en', 'ms'] )],
    ] );

    $locale = $validated['locale'];

    app()->setLocale( $locale );
    $request->session()->put( 'locale', $locale );

    return back();
} )->name( 'locale.switch' );
