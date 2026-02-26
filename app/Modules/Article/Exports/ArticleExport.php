<?php

declare(strict_types=1);

namespace App\Modules\Article\Exports;

use App\Contracts\Exportable;
use OpenSpout\Writer\XLSX\Writer;
use App\Support\Status\StatusType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Query\JoinClause;
use App\Support\Export\InteractsWithLargeXlsxExport;

class ArticleExport implements Exportable
{
    use InteractsWithLargeXlsxExport;

    public function store( string $path ): void
    {
        $fullPath = Storage::disk( 'local' )->path( $path );
        $tmpPath  = $fullPath . '.tmp';
        $headers  = ['ID', 'Title', 'Slug', 'Author', 'Status', 'Published At', 'Created At'];

        $this->ensureDirectory( $fullPath );

        $writer = new Writer;
        $writer->openToFile( $tmpPath );
        $this->initializeWorksheet( $writer, 'Articles', $headers );

        DB::table( 'articles' )
            ->leftJoin( 'users', 'articles.user_id', '=', 'users.id' )
            ->leftJoin( 'statuses', function ( JoinClause $join ): void {
                $join->on( 'articles.status_id', '=', 'statuses.id' )
                    ->where( 'statuses.type', StatusType::Article->value );
            } )
            ->select(
                'articles.id',
                'articles.title',
                'articles.slug',
                'users.name as author',
                'statuses.key as status',
                'articles.published_at',
                'articles.created_at'
            )
            ->lazyById( $this->exportChunkSize(), 'articles.id', 'id' )
            ->each( function ( object $row ) use ( $writer, $headers ): void {
                $this->addDataRow( $writer, 'Articles', $headers, [
                    $this->cellValue( $row->id ?? null ),
                    $this->cellValue( $row->title ?? null ),
                    $this->cellValue( $row->slug ?? null ),
                    $this->cellValue( $row->author ?? null ),
                    $this->cellValue( $row->status ?? null ),
                    $this->cellValue( $row->published_at ?? null ),
                    $this->cellValue( $row->created_at ?? null ),
                ] );
            } );

        $writer->close();
        rename( $tmpPath, $fullPath );
    }
}
