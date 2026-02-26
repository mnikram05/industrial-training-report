<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Support\Transfer\DataTransfer;
use App\Support\Transfer\DataTransferType;
use App\Support\Transfer\DataTransferStatus;
use App\Support\Export\ExportDownloadTracker;

class ExportStatusController extends Controller
{
    public function __construct(
        private ExportDownloadTracker $exportDownloadTracker,
    ) {}

    public function __invoke( Request $request, DataTransfer $transfer ): JsonResponse
    {
        $requesterId = $request->user()?->getAuthIdentifier();

        abort_unless( $transfer->type === DataTransferType::Export, 404 );
        abort_unless(
            is_string( $transfer->initiated_by )
                && is_scalar( $requesterId )
                && (string) $requesterId === $transfer->initiated_by,
            404
        );

        $downloadUrl = null;

        if (
            $transfer->status === DataTransferStatus::Completed
            && $this->exportDownloadTracker->shouldShow( $transfer->path )
        ) {
            $downloadUrl = route( 'exports.download', ['path' => $transfer->path] );
        }

        return response()->json( [
            'status'       => $transfer->status->value,
            'download_url' => $downloadUrl,
        ] );
    }
}
