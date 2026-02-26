<?php

declare(strict_types=1);

namespace App\Support\Breadcrumbs;

use Closure;

final class Breadcrumbs
{
    public static function for( string $name, Closure $definition ): void
    {
        app( BreadcrumbRegistry::class )->for( $name, $definition );
    }

    /**
     * @return list<BreadcrumbItem>
     */
    public static function current(): array
    {
        return app( BreadcrumbRegistry::class )->current( request() );
    }

    /**
     * @return list<BreadcrumbItem>
     */
    public static function generate( string $name, mixed ...$parameters ): array
    {
        return app( BreadcrumbRegistry::class )->generate( $name, ...$parameters );
    }
}
