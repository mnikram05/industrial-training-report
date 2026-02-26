<?php

declare(strict_types=1);

namespace App\Support\Status;

enum StatusType: string
{
    case Module       = 'module';
    case Article      = 'article';
    case Landing      = 'landing';
    case DataTransfer = 'data_transfer';
}
