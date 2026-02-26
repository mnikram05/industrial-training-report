<?php

declare(strict_types=1);

namespace App\Jobs;

use Throwable;
use RuntimeException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Support\Transfer\DataTransferRecorder;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class ProcessImport implements ShouldQueue
{
    use Queueable;

    public int $timeout = 1800;

    public int $tries = 5;

    public int $maxExceptions = 3;

    /**
     * @param  class-string<\App\Contracts\Importable>  $importClass
     */
    public function __construct(
        public string $importClass,
        public string $storedPath,
        public int $transferId,
        public string|int|null $initiatedBy = null,
    ) {
        $this->onQueue( 'imports' );
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            ( new WithoutOverlapping( 'transfer:import:' . $this->transferId ) )
                ->releaseAfter( 30 )
                ->expireAfter( 600 )
                ->shared(),
        ];
    }

    /**
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [15, 60, 180];
    }

    /**
     * Execute the job.
     */
    public function handle( DataTransferRecorder $dataTransferRecorder ): void
    {
        DB::disableQueryLog();
        Context::add( [
            'transfer.operation'    => 'import',
            'transfer.id'           => $this->transferId,
            'transfer.stored_path'  => $this->storedPath,
            'transfer.handler'      => $this->importClass,
            'transfer.initiated_by' => $this->initiatedBy,
        ] );

        $dataTransferRecorder->markRunning( $this->transferId );

        $absolutePath = Storage::disk( 'local' )->path( $this->storedPath );

        if ( ! is_file( $absolutePath ) ) {
            $dataTransferRecorder->markFailed( $this->transferId, new RuntimeException( 'Import file not found.' ) );

            return;
        }

        try {
            /** @var \App\Contracts\Importable $import */
            $import = new $this->importClass;
            $import->import( $absolutePath, $this->initiatedBy );

            $dataTransferRecorder->markCompleted( $this->transferId );
        } catch ( Throwable $exception ) {
            $dataTransferRecorder->markFailed( $this->transferId, $exception );

            throw $exception;
        } finally {
            Storage::disk( 'local' )->delete( $this->storedPath );
        }
    }
}
