<?php

declare(strict_types=1);

namespace App\Modules\Role\Exports;

use App\Contracts\Exportable;
use OpenSpout\Writer\XLSX\Writer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Support\Export\InteractsWithLargeXlsxExport;

class RoleExport implements Exportable
{
    use InteractsWithLargeXlsxExport;

    public function store( string $path ): void
    {
        $fullPath = Storage::disk( 'local' )->path( $path );
        $tmpPath  = $fullPath . '.tmp';
        $headers  = ['ID', 'Name', 'Permissions', 'Users Count', 'Created At'];

        $this->ensureDirectory( $fullPath );

        $writer = new Writer;
        $writer->openToFile( $tmpPath );
        $this->initializeWorksheet( $writer, 'Roles', $headers );

        $groupConcat = DB::getDriverName() === 'sqlite'
            ? "GROUP_CONCAT(p.name, ', ')"
            : "GROUP_CONCAT(p.name SEPARATOR ', ')";

        $permSubquery = "(SELECT {$groupConcat} FROM role_has_permissions rhp"
            . ' JOIN permissions p ON rhp.permission_id = p.id'
            . ' WHERE rhp.role_id = roles.id)';
        $usersSubquery = '(SELECT COUNT(*) FROM model_has_roles WHERE model_has_roles.role_id = roles.id)';

        DB::table( 'roles' )
            ->select(
                'roles.id',
                'roles.name',
                DB::raw( $permSubquery . ' as permission_names' ),
                DB::raw( $usersSubquery . ' as users_count' ),
                'roles.created_at'
            )
            ->lazyById( $this->exportChunkSize(), 'roles.id', 'id' )
            ->each( function ( object $row ) use ( $writer, $headers ): void {
                $this->addDataRow( $writer, 'Roles', $headers, [
                    $this->cellValue( $row->id ?? null ),
                    $this->cellValue( $row->name ?? null ),
                    $this->cellValue( $row->permission_names ?? null ),
                    $this->cellValue( $row->users_count ?? null ),
                    $this->cellValue( $row->created_at ?? null ),
                ] );
            } );

        $writer->close();
        rename( $tmpPath, $fullPath );
    }
}
