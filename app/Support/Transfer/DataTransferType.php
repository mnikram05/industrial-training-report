<?php

declare(strict_types=1);

namespace App\Support\Transfer;

enum DataTransferType: string
{
    case Import = 'import';
    case Export = 'export';
}
