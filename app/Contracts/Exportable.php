<?php

declare(strict_types=1);

namespace App\Contracts;

interface Exportable
{
    public function store( string $path ): void;
}
