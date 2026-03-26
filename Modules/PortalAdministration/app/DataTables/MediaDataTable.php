<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\DataTables;

use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;
use App\Support\DataTable\BaseModuleDataTable;
use Modules\PortalAdministration\Models\Media;

class MediaDataTable extends BaseModuleDataTable
{
    protected ?int $typeId = null;

    public function setTypeId( ?int $typeId ): static
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * @return Builder<Media>
     */
    public function query(): Builder
    {
        return Media::query()
            ->with( 'createdBy' )
            ->when( $this->typeId, fn ( Builder $q ) => $q->where( 'type_id', $this->typeId ) )
            ->latest();
    }

    public function ajax(): JsonResponse
    {
        return DataTables::eloquent( $this->query() )
            ->addIndexColumn()
            ->addColumn( 'preview', static fn ( Media $media ): string => view( 'portaladministration::media.partials.datatables_preview', [
                'media' => $media,
            ] )->render() )
            ->addColumn( 'human_size', static fn ( Media $media ): string => $media->human_size )
            ->addColumn( 'uploader', static fn ( Media $media ): string => $media->createdBy?->name ?? '' )
            ->addColumn( 'action', static fn ( Media $media ): string => view( 'portaladministration::media.partials.datatables_actions', [
                'media' => $media,
            ] )->render() )
            ->editColumn( 'created_at', function ( $q ) {
                return $q->created_at ? $q->created_at->format( 'd/m/Y H:i' ) : '';
            } )
            ->rawColumns( ['preview', 'action'] )
            ->toJson();
    }

    protected function tableId(): string
    {
        return 'media-table';
    }

    protected function ajaxRouteName(): string
    {
        return 'media.index';
    }

    public function ajaxUrl(): string
    {
        return route( $this->ajaxRouteName(), array_filter( ['type_id' => $this->typeId] ) );
    }

    /**
     * @return list<array{label: string, class?: string}>
     */
    protected function headings(): array
    {
        return [
            ['label' => '#', 'class' => 'px-4 py-3 text-left font-medium w-14'],
            ['label' => __( 'modules/portal-administration/media.fields.preview' ), 'class' => 'px-4 py-3 text-left font-medium w-20'],
            ['label' => __( 'modules/portal-administration/media.fields.name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/media.fields.file_name' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/media.fields.mime_type' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/media.fields.size' ), 'class' => 'px-4 py-3 text-left font-medium w-24'],
            ['label' => __( 'modules/portal-administration/media.fields.collection' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/media.fields.uploaded_by' ), 'class' => 'px-4 py-3 text-left font-medium'],
            ['label' => __( 'modules/portal-administration/media.fields.created_at' ), 'class' => 'px-4 py-3 text-left font-medium w-32'],
            ['label' => __( 'crud.action' ), 'class' => 'px-4 py-3 text-right font-medium'],
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function columns(): array
    {
        return [
            ['data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'searchable' => false, 'orderable' => false, 'className' => 'w-14 text-left'],
            ['data' => 'preview', 'name' => 'preview', 'searchable' => false, 'orderable' => false, 'className' => 'w-20'],
            ['data' => 'name', 'name' => 'name'],
            ['data' => 'file_name', 'name' => 'file_name'],
            ['data' => 'mime_type', 'name' => 'mime_type'],
            ['data' => 'human_size', 'name' => 'size', 'searchable' => false],
            ['data' => 'collection', 'name' => 'collection'],
            ['data' => 'uploader', 'name' => 'uploader', 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at'],
            ['data' => 'action', 'name' => 'action', 'searchable' => false, 'orderable' => false, 'className' => 'text-right whitespace-nowrap'],
        ];
    }

    public function filterPlaceholder(): string
    {
        return __( 'modules/portal-administration/media.filter' );
    }
}
