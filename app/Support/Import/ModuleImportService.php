<?php

declare(strict_types=1);

namespace App\Support\Import;

use NoDiscard;
use RuntimeException;
use App\Jobs\ProcessImport;
use Illuminate\Http\UploadedFile;
use App\Support\Transfer\DataTransferRecorder;
use Illuminate\Contracts\Auth\Authenticatable;

class ModuleImportService
{
    public function __construct(
        protected DataTransferRecorder $dataTransferRecorder
    ) {}

    /**
     * @param  class-string<\App\Contracts\Importable>  $importClass
     */
    #[NoDiscard]
    public function queue(
        UploadedFile $uploadedFile,
        string $resourceName,
        string $importClass,
        ?Authenticatable $causer = null
    ): ImportDispatchResult {
        $storedPath = $uploadedFile->store( sprintf( 'imports/%s', $resourceName ), 'local' );

        if ( ! is_string( $storedPath ) || $storedPath === '' ) {
            throw new RuntimeException( 'Unable to store uploaded import file.' );
        }

        $transfer = $this->dataTransferRecorder->createQueuedImport(
            resource: $resourceName,
            storedPath: $storedPath,
            originalFilename: $uploadedFile->getClientOriginalName(),
            handler: $importClass,
            causer: $causer,
        );

        $initiatedBy           = $causer?->getAuthIdentifier();
        $normalizedInitiatedBy = is_string( $initiatedBy ) || is_int( $initiatedBy )
            ? $initiatedBy
            : null;

        ProcessImport::dispatch(
            $importClass,
            $storedPath,
            $transfer->id,
            $normalizedInitiatedBy,
        );

        return new ImportDispatchResult(
            transferId: $transfer->id,
            storedPath: $storedPath,
            originalFilename: $uploadedFile->getClientOriginalName(),
        );
    }
}
