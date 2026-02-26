<?php

declare(strict_types=1);

namespace App\Support\Export;

use Illuminate\Contracts\Session\Session;

class ExportDownloadTracker
{
    public function __construct(
        private Session $session,
    ) {}

    public function markDownloaded( string $path ): void
    {
        $downloaded = $this->downloadedPaths();

        if ( ! in_array( $path, $downloaded, true ) ) {
            $this->session->put( 'downloaded_exports', [...$downloaded, $path] );
        }
    }

    public function shouldShow( ?string $path ): bool
    {
        if ( $path === null ) {
            return false;
        }

        return ! in_array( $path, $downloaded = $this->downloadedPaths(), true );
    }

    public function visiblePath( ?string $path ): ?string
    {
        return $this->shouldShow( $path ) ? $path : null;
    }

    /**
     * @return list<string>
     */
    private function downloadedPaths(): array
    {
        $paths = $this->session->get( 'downloaded_exports', [] );

        if ( ! is_array( $paths ) ) {
            return [];
        }

        return array_values(
            array_filter(
                $paths,
                static fn ( $path ): bool => is_string( $path )
            )
        );
    }
}
