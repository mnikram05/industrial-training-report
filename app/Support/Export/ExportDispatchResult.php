<?php

declare(strict_types=1);

namespace App\Support\Export;

final readonly class ExportDispatchResult
{
    public function __construct(
        public int $transferId,
        public string $filename,
        public string $downloadUrl,
    ) {}
}
