<?php

declare(strict_types=1);

namespace App\Support\Transfer;

use App\Support\Status\StatusType;
use App\Support\Status\StatusCatalog;

enum DataTransferStatus: string
{
    case Queued    = 'queued';
    case Running   = 'running';
    case Completed = 'completed';
    case Failed    = 'failed';

    public function id(): int
    {
        return StatusCatalog::id( StatusType::DataTransfer, $this->value );
    }

    public function nameEn(): string
    {
        return match ( $this ) {
            self::Queued    => 'Queued',
            self::Running   => 'Running',
            self::Completed => 'Completed',
            self::Failed    => 'Failed',
        };
    }

    public function nameMs(): string
    {
        return match ( $this ) {
            self::Queued    => 'Dalam giliran',
            self::Running   => 'Sedang diproses',
            self::Completed => 'Selesai',
            self::Failed    => 'Gagal',
        };
    }
}
