<?php

declare(strict_types=1);

namespace App\Support\Breadcrumbs;

final class BreadcrumbTrail
{
    /**
     * @var list<BreadcrumbItem>
     */
    private array $items = [];

    public function __construct(
        private BreadcrumbRegistry $registry,
    ) {}

    public function push( string $label, ?string $url = null ): self
    {
        $this->items[] = new BreadcrumbItem( $label, $url );

        return $this;
    }

    public function parent( string $name, mixed ...$parameters ): self
    {
        $this->items = [...$this->items, ...$this->registry->generate( $name, ...$parameters )];

        return $this;
    }

    /**
     * @return list<BreadcrumbItem>
     */
    public function items(): array
    {
        return $this->items;
    }
}
