<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Support\Export\ExportDownloadTracker;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportDownloadController extends Controller
{
    public function __construct(
        private ExportDownloadTracker $exportDownloadTracker
    ) {}

    public function __invoke( Request $request ): BinaryFileResponse
    {
        $path = $request->query( 'path' );

        abort_unless( is_string( $path ) && str_starts_with( $path, 'exports/' ), 404 );
        abort_unless( Storage::disk( 'local' )->exists( $path ), 404 );

        $this->exportDownloadTracker->markDownloaded( $path );

        return response()->download(
            Storage::disk( 'local' )->path( $path ),
            basename( $path ),
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }
}
