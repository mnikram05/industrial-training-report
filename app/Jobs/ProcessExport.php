<?php

declare(strict_types=1);

namespace App\Jobs;

use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Context;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Support\Transfer\DataTransferRecorder;
use Illuminate\Queue\Middleware\WithoutOverlapping;

class ProcessExport implements ShouldQueue
{
    use Queueable;

    public int $timeout = 1800;

    public int $tries = 5;

    public int $maxExceptions = 3;

    /**
     * @param  class-string<\App\Contracts\Exportable>  $exportClass
     */
    public function __construct(
        public string $exportClass,
        public string $filename,
        public int $transferId,
    ) {
        $this->onQueue( 'exports' );
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [
            ( new WithoutOverlapping( 'transfer:export:' . $this->transferId ) )
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

    public function handle( DataTransferRecorder $dataTransferRecorder ): void
    {
        DB::disableQueryLog();
        Context::add( [
            'transfer.operation' => 'export',
            'transfer.id'        => $this->transferId,
            'transfer.filename'  => $this->filename,
            'transfer.handler'   => $this->exportClass,
        ] );

        $dataTransferRecorder->markRunning( $this->transferId );

        try {
            /** @var \App\Contracts\Exportable $export */
            $export = new $this->exportClass;
            $export->store( $this->filename );

            $dataTransferRecorder->markCompleted( $this->transferId );
        } catch ( Throwable $exception ) {
            $dataTransferRecorder->markFailed( $this->transferId, $exception );

            throw $exception;
        }
    }
}
