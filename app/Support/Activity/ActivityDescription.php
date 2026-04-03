<?php

declare(strict_types=1);

namespace App\Support\Activity;

final class ActivityDescription
{
    public static function create( string $resource ): string
    {
        return __( 'ui.create' ) . ' ' . $resource;
    }

    public static function edit( string $resource ): string
    {
        return __( 'ui.edit' ) . ' ' . $resource;
    }

    public static function delete( string $resource ): string
    {
        return __( 'ui.delete' ) . ' ' . $resource;
    }

    public static function export( string $resource ): string
    {
        return __( 'ui.export' ) . ' ' . $resource;
    }

    public static function importXlsx( string $resource ): string
    {
        return __( 'ui.import_xlsx' ) . ' ' . $resource;
    }

    public static function publish( string $resource ): string
    {
        return __( 'ui.publish' ) . ' ' . $resource;
    }

    public static function unpublish( string $resource ): string
    {
        return __( 'ui.unpublish' ) . ' ' . $resource;
    }

    public static function login(): string
    {
        return __( 'ui.login' );
    }

    public static function logout(): string
    {
        return __( 'ui.logout' );
    }

    public static function impersonate(): string
    {
        return __( 'ui.impersonate' );
    }

    public static function impersonation(): string
    {
        return __( 'ui.impersonation' );
    }
}
