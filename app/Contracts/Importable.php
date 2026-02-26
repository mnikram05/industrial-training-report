<?php

declare(strict_types=1);

namespace App\Contracts;

interface Importable
{
    public function import( string $filePath, string|int|null $initiatedBy = null ): void;
}
