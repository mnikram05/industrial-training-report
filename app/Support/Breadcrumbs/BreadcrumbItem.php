<?php

declare(strict_types=1);

namespace App\Support\Breadcrumbs;

final readonly class BreadcrumbItem
{
    public function __construct(
        public string $label,
        public ?string $url = null,
    ) {}
}
