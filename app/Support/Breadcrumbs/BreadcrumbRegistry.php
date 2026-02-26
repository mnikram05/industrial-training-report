<?php

declare(strict_types=1);

namespace App\Support\Breadcrumbs;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class BreadcrumbRegistry
{
    /**
     * @var array<string, Closure>
     */
    private array $definitions = [];

    /**
     * @var list<string>
     */
    private array $resolvingStack = [];

    public function for( string $name, Closure $definition ): void
    {
        $this->definitions[$name] = $definition;
    }

    /**
     * @return list<BreadcrumbItem>
     */
    public function current( Request $request ): array
    {
        $route = $request->route();

        if ( $route === null ) {
            return [];
        }

        $name = $route->getName();

        if ( ! is_string( $name ) || $name === '' ) {
            return [];
        }

        return $this->generate( $name, ...array_values( $route->parameters() ) );
    }

    /**
     * @return list<BreadcrumbItem>
     */
    public function generate( string $name, mixed ...$parameters ): array
    {
        $definition = $this->definitions[$name] ?? null;

        if ( ! $definition instanceof Closure ) {
            return [];
        }

        if ( in_array( $name, $this->resolvingStack, true ) ) {
            return [];
        }

        $this->resolvingStack[] = $name;

        $trail = new BreadcrumbTrail( $this );

        try {
            $definition( $trail, ...$parameters );
        } finally {
            array_pop( $this->resolvingStack );
        }

        return $trail->items();
    }
}
