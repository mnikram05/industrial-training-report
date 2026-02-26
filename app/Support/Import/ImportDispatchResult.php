<?php

declare(strict_types=1);

namespace App\Support\Import;

final readonly class ImportDispatchResult
{
    public function __construct(
        public int $transferId,
        public string $storedPath,
        public string $originalFilename,
    ) {}
}
