<?php

declare(strict_types=1);

namespace App\Modules\User\Exports;

use App\Contracts\Exportable;
use OpenSpout\Writer\XLSX\Writer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Support\Export\InteractsWithLargeXlsxExport;

class UserExport implements Exportable
{
    use InteractsWithLargeXlsxExport;

    public function store( string $path ): void
    {
        $fullPath = Storage::disk( 'local' )->path( $path );
        $tmpPath  = $fullPath . '.tmp';
        $headers  = ['ID', 'Name', 'Email', 'Roles', 'Created At'];

        $this->ensureDirectory( $fullPath );

        $writer = new Writer;
        $writer->openToFile( $tmpPath );
        $this->initializeWorksheet( $writer, 'Users', $headers );

        $groupConcat = DB::getDriverName() === 'sqlite'
            ? "GROUP_CONCAT(r.name, ', ')"
            : "GROUP_CONCAT(r.name SEPARATOR ', ')";

        $roleSubquery = "(SELECT {$groupConcat} FROM model_has_roles mhr"
            . ' JOIN roles r ON mhr.role_id = r.id'
            . ' WHERE mhr.model_id = users.id'
            . " AND mhr.model_type = 'App\\\\Modules\\\\User\\\\Models\\\\User')";

        DB::table( 'users' )
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw( $roleSubquery . ' as role_names' ),
                'users.created_at'
            )
            ->lazyById( $this->exportChunkSize(), 'users.id', 'id' )
            ->each( function ( object $row ) use ( $writer, $headers ): void {
                $this->addDataRow( $writer, 'Users', $headers, [
                    $this->cellValue( $row->id ?? null ),
                    $this->cellValue( $row->name ?? null ),
                    $this->cellValue( $row->email ?? null ),
                    $this->cellValue( $row->role_names ?? null ),
                    $this->cellValue( $row->created_at ?? null ),
                ] );
            } );

        $writer->close();
        rename( $tmpPath, $fullPath );
    }
}
