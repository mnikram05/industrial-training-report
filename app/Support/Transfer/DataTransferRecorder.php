<?php

declare(strict_types=1);

namespace App\Support\Transfer;

use Throwable;
use Illuminate\Contracts\Auth\Authenticatable;

class DataTransferRecorder
{
    public function createQueuedExport(
        string $resource,
        string $path,
        string $handler,
        ?Authenticatable $causer = null
    ): DataTransfer {
        return DataTransfer::query()->create( [
            'type'         => DataTransferType::Export,
            'resource'     => $resource,
            'status'       => DataTransferStatus::Queued,
            'disk'         => 'local',
            'path'         => $path,
            'handler'      => $handler,
            'initiated_by' => $this->causerId( $causer ),
        ] );
    }

    public function createQueuedImport(
        string $resource,
        string $storedPath,
        string $originalFilename,
        string $handler,
        ?Authenticatable $causer = null
    ): DataTransfer {
        return DataTransfer::query()->create( [
            'type'              => DataTransferType::Import,
            'resource'          => $resource,
            'status'            => DataTransferStatus::Queued,
            'disk'              => 'local',
            'path'              => $storedPath,
            'original_filename' => $originalFilename,
            'handler'           => $handler,
            'initiated_by'      => $this->causerId( $causer ),
        ] );
    }

    public function markRunning( int $transferId ): void
    {
        DataTransfer::query()
            ->whereKey( $transferId )
            ->update( [
                'status_id'     => DataTransferStatus::Running->id(),
                'started_at'    => now(),
                'failed_at'     => null,
                'error_message' => null,
            ] );
    }

    public function markCompleted( int $transferId ): void
    {
        DataTransfer::query()
            ->whereKey( $transferId )
            ->update( [
                'status_id'    => DataTransferStatus::Completed->id(),
                'completed_at' => now(),
            ] );
    }

    public function markFailed( int $transferId, Throwable $exception ): void
    {
        DataTransfer::query()
            ->whereKey( $transferId )
            ->update( [
                'status_id'     => DataTransferStatus::Failed->id(),
                'failed_at'     => now(),
                'error_message' => mb_substr( $exception->getMessage(), 0, 2000 ),
            ] );
    }

    private function causerId( ?Authenticatable $causer ): ?string
    {
        if ( $causer === null ) {
            return null;
        }

        $identifier = $causer->getAuthIdentifier();

        if ( ! is_string( $identifier ) && ! is_int( $identifier ) ) {
            return null;
        }

        return (string) $identifier;
    }
}
