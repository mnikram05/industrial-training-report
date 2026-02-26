<?php

declare(strict_types=1);

namespace App\Modules\Status\Exports;

use App\Contracts\Exportable;
use OpenSpout\Writer\XLSX\Writer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\JoinClause;
use App\Support\Export\InteractsWithLargeXlsxExport;

class StatusExport implements Exportable
{
    use InteractsWithLargeXlsxExport;

    public function store( string $path ): void
    {
        $fullPath = Storage::disk( 'local' )->path( $path );
        $tmpPath  = $fullPath . '.tmp';
        $headers  = ['ID', 'Type', 'Key', 'Parent ID', 'Parent Key', 'Name EN', 'Name MS', 'Created At'];

        $this->ensureDirectory( $fullPath );

        $writer = new Writer;
        $writer->openToFile( $tmpPath );
        $this->initializeWorksheet( $writer, 'Statuses', $headers );

        DB::table( 'statuses' )
            ->leftJoin( 'statuses as parents', static function ( JoinClause $join ): void {
                $join->on( 'statuses.parent_id', '=', 'parents.id' );
            } )
            ->select(
                'statuses.id',
                'statuses.type',
                'statuses.key',
                'statuses.parent_id',
                'parents.key as parent_key',
                'statuses.name_en',
                'statuses.name_ms',
                'statuses.created_at',
            )
            ->orderBy( 'statuses.id' )
            ->lazyById( $this->exportChunkSize(), 'statuses.id', 'id' )
            ->each( function ( object $row ) use ( $writer, $headers ): void {
                $this->addDataRow( $writer, 'Statuses', $headers, [
                    $this->cellValue( $row->id ?? null ),
                    $this->cellValue( $row->type ?? null ),
                    $this->cellValue( $row->key ?? null ),
                    $this->cellValue( $row->parent_id ?? null ),
                    $this->cellValue( $row->parent_key ?? null ),
                    $this->cellValue( $row->name_en ?? null ),
                    $this->cellValue( $row->name_ms ?? null ),
                    $this->cellValue( $row->created_at ?? null ),
                ] );
            } );

        $writer->close();
        rename( $tmpPath, $fullPath );
    }
}
