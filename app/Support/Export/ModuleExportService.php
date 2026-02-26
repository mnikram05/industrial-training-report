<?php

declare(strict_types=1);

namespace App\Support\Export;

use NoDiscard;
use App\Jobs\ProcessExport;
use App\Support\Transfer\DataTransferRecorder;
use Illuminate\Contracts\Auth\Authenticatable;

class ModuleExportService
{
    public function __construct(
        protected DataTransferRecorder $dataTransferRecorder
    ) {}

    /**
     * @param  class-string<\App\Contracts\Exportable>  $exportClass
     */
    #[NoDiscard]
    public function queue(
        string $resourceName,
        string $exportClass,
        ?Authenticatable $causer = null
    ): ExportDispatchResult {
        $filename = sprintf( 'exports/%s-%s.xlsx', $resourceName, now()->format( 'YmdHisv' ) );

        $transfer = $this->dataTransferRecorder->createQueuedExport(
            resource: $resourceName,
            path: $filename,
            handler: $exportClass,
            causer: $causer,
        );

        ProcessExport::dispatch( $exportClass, $filename, $transfer->id );

        return new ExportDispatchResult(
            transferId: $transfer->id,
            filename: $filename,
            downloadUrl: route( 'exports.download', ['path' => $filename] ),
        );
    }
}
