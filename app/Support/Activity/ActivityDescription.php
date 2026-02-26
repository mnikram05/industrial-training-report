<?php

declare(strict_types=1);

namespace App\Support\Activity;

final class ActivityDescription
{
    public static function create( string $resource ): string
    {
        return __( 'Create' ) . ' ' . $resource;
    }

    public static function edit( string $resource ): string
    {
        return __( 'Edit' ) . ' ' . $resource;
    }

    public static function delete( string $resource ): string
    {
        return __( 'Delete' ) . ' ' . $resource;
    }

    public static function export( string $resource ): string
    {
        return __( 'Export' ) . ' ' . $resource;
    }

    public static function importXlsx( string $resource ): string
    {
        return __( 'Import XLSX' ) . ' ' . $resource;
    }

    public static function publish( string $resource ): string
    {
        return __( 'Publish' ) . ' ' . $resource;
    }

    public static function unpublish( string $resource ): string
    {
        return __( 'Unpublish' ) . ' ' . $resource;
    }

    public static function login(): string
    {
        return 'Login';
    }

    public static function logout(): string
    {
        return 'Logout';
    }

    public static function impersonate(): string
    {
        return __( 'Impersonate' );
    }

    public static function impersonation(): string
    {
        return __( 'Impersonation' );
    }
}
