<?php

declare(strict_types=1);

namespace App\Modules\Landing\Exports;

use App\Contracts\Exportable;
use OpenSpout\Writer\XLSX\Writer;
use App\Support\Status\StatusType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\JoinClause;
use App\Support\Export\InteractsWithLargeXlsxExport;

class LandingExport implements Exportable
{
    use InteractsWithLargeXlsxExport;

    public function store( string $path ): void
    {
        $fullPath = Storage::disk( 'local' )->path( $path );
        $tmpPath  = $fullPath . '.tmp';
        $headers  = ['ID', 'Title EN', 'Title MS', 'Slug', 'Status', 'Created At'];

        $this->ensureDirectory( $fullPath );

        $writer = new Writer;
        $writer->openToFile( $tmpPath );
        $this->initializeWorksheet( $writer, 'Landings', $headers );

        DB::table( 'landings' )
            ->leftJoin( 'statuses', function ( JoinClause $join ): void {
                $join->on( 'landings.status_id', '=', 'statuses.id' )
                    ->where( 'statuses.type', StatusType::Landing->value );
            } )
            ->select( 'landings.id', 'landings.content', 'landings.slug', 'statuses.key as status', 'landings.created_at' )
            ->lazyById( $this->exportChunkSize(), 'landings.id', 'id' )
            ->each( function ( object $row ) use ( $writer, $headers ): void {
                $this->addDataRow( $writer, 'Landings', $headers, [
                    $this->cellValue( $row->id ?? null ),
                    $this->cellValue( $this->contentTitle( $row->content ?? null, 'en' ) ),
                    $this->cellValue( $this->contentTitle( $row->content ?? null, 'ms' ) ),
                    $this->cellValue( $row->slug ?? null ),
                    $this->cellValue( $row->status ?? null ),
                    $this->cellValue( $row->created_at ?? null ),
                ] );
            } );

        $writer->close();
        rename( $tmpPath, $fullPath );
    }

    private function contentTitle( mixed $content, string $locale ): string
    {
        if ( is_string( $content ) ) {
            /** @var mixed $decoded */
            $decoded = json_decode( $content, true );
            $content = $decoded;
        }

        if ( ! is_array( $content ) ) {
            return '';
        }

        $heroTitle = data_get( $content, 'hero.title' );

        if ( is_array( $heroTitle ) ) {
            $primary = $locale === 'ms'
                ? $this->stringValue( $heroTitle['ms'] ?? null )
                : $this->stringValue( $heroTitle['en'] ?? null );
            $fallback = $locale === 'ms'
                ? $this->stringValue( $heroTitle['en'] ?? null )
                : $this->stringValue( $heroTitle['ms'] ?? null );

            return $primary !== '' ? $primary : $fallback;
        }

        return $this->stringValue( $heroTitle );
    }

    private function stringValue( mixed $value ): string
    {
        return is_scalar( $value ) ? trim( (string) $value ) : '';
    }
}
