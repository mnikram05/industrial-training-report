<?php

declare(strict_types=1);

namespace App\Modules\ActivityLog\Exports;

use App\Contracts\Exportable;
use OpenSpout\Writer\XLSX\Writer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\JoinClause;
use App\Support\Export\InteractsWithLargeXlsxExport;

class ActivityLogExport implements Exportable
{
    use InteractsWithLargeXlsxExport;

    public function store( string $path ): void
    {
        $fullPath = Storage::disk( 'local' )->path( $path );
        $tmpPath  = $fullPath . '.tmp';
        $headers  = ['ID', 'Log Name', 'Description', 'User', 'Subject', 'Event', 'Created At'];

        $this->ensureDirectory( $fullPath );

        $writer = new Writer;
        $writer->openToFile( $tmpPath );
        $this->initializeWorksheet( $writer, 'Activity Logs', $headers );

        DB::table( 'activity_log' )
            ->leftJoin( 'users', function ( JoinClause $join ): void {
                $join->on( 'activity_log.causer_id', '=', 'users.id' )
                    ->where( 'activity_log.causer_type', 'App\\Modules\\User\\Models\\User' );
            } )
            ->select(
                'activity_log.id',
                'activity_log.log_name',
                'activity_log.description',
                'users.name as causer_name',
                'activity_log.subject_type',
                'activity_log.subject_id',
                'activity_log.event',
                'activity_log.created_at'
            )
            ->lazyById( $this->exportChunkSize(), 'activity_log.id', 'id' )
            ->each( function ( object $row ) use ( $writer, $headers ): void {
                $subjectType = is_string( $row->subject_type ?? null ) ? $row->subject_type : null;
                $subjectId   = is_scalar( $row->subject_id ?? null ) ? (string) $row->subject_id : '';
                $subject     = $subjectType ? class_basename( $subjectType ) . ' #' . $subjectId : null;

                $this->addDataRow( $writer, 'Activity Logs', $headers, [
                    $this->cellValue( $row->id ?? null ),
                    $this->cellValue( $row->log_name ?? null ),
                    $this->cellValue( $row->description ?? null ),
                    $this->cellValue( $row->causer_name ?? null ),
                    $this->cellValue( $subject ),
                    $this->cellValue( $row->event ?? null ),
                    $this->cellValue( $row->created_at ?? null ),
                ] );
            } );

        $writer->close();
        rename( $tmpPath, $fullPath );
    }
}
