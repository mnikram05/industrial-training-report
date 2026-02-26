<?php

declare(strict_types=1);

namespace App\Support\Export;

use App\Support\Transfer\DataTransfer;
use App\Support\Transfer\DataTransferType;
use App\Support\Transfer\DataTransferStatus;
use Illuminate\Contracts\Auth\Authenticatable;

class LatestCompletedExportPathResolver
{
    public function __construct(
        private ExportDownloadTracker $exportDownloadTracker,
    ) {}

    public function resolve( string $resourceName, ?Authenticatable $causer = null ): ?string
    {
        $query = DataTransfer::query()
            ->where( 'type', DataTransferType::Export )
            ->where( 'resource', $resourceName )
            ->where( 'status_id', DataTransferStatus::Completed->id() );

        $identifier = $causer?->getAuthIdentifier();

        if ( is_string( $identifier ) || is_int( $identifier ) ) {
            $query->where( 'initiated_by', (string) $identifier );
        }

        $path = $query
            ->latest( 'created_at' )
            ->value( 'path' );

        return $this->exportDownloadTracker->visiblePath(
            is_string( $path ) ? $path : null,
        );
    }
}
