<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Reference\Models\DataReference;
use Modules\PortalAdministration\DataTables\MediaDataTable;
use Modules\PortalAdministration\Models\Media;
use Modules\PortalAdministration\Support\PortalPublicMediaPaths;

class MediaController extends Controller
{
    public function __construct(
        protected MediaDataTable $mediaDataTable,
    ) {}

    public function index( Request $request ): JsonResponse|View
    {
        $typeId = $request->integer( 'type_id' ) ?: null;

        $this->mediaDataTable->setTypeId( $typeId );

        if ( $request->ajax() ) {
            return $this->mediaDataTable->ajax();
        }

        $type = $typeId ? DataReference::find( $typeId ) : null;

        return view( 'portaladministration::media.index', [
            'dataTable' => $this->mediaDataTable,
            'type'      => $type,
        ] );
    }

    public function create( Request $request ): View
    {
        $typeId = $request->integer( 'type_id' ) ?: null;

        return view( 'portaladministration::media.create', [
            'typeOptions' => $this->getTypeOptions(),
            'typeId'      => $typeId,
        ] );
    }

    public function store( Request $request ): RedirectResponse
    {
        $request->validate( [
            'files'      => ['required', 'array', 'min:1'],
            'files.*'    => ['required', 'file', 'max:10240'],
            'type_id'    => ['nullable', 'integer', 'exists:zz_data_references,id'],
            'collection' => ['nullable', 'string', 'max:255'],
        ] );

        $collection = $request->input( 'collection' );
        $typeId     = $request->integer( 'type_id' ) ?: null;

        foreach ( $request->file( 'files' ) as $file ) {
            $originalName = $file->getClientOriginalName();
            $name         = pathinfo( $originalName, PATHINFO_FILENAME );
            $path         = $this->storeUploadedFileInPortalPath( $file );

            Media::create( [
                'type_id'    => $typeId,
                'name'       => $name,
                'file_name'  => $originalName,
                'mime_type'  => $file->getMimeType(),
                'path'       => $path,
                'disk'       => 'public',
                'size'       => $file->getSize(),
                'collection' => $collection,
                'created_by' => auth()->id(),
            ] );
        }

        $redirect = $typeId
            ? route( 'media.index', ['type_id' => $typeId] )
            : route( 'media.index' );

        return redirect( $redirect )->with( 'status', 'media-uploaded' );
    }

    public function show( Media $medium ): View
    {
        return view( 'portaladministration::media.show', ['media' => $medium] );
    }

    public function update( Request $request, Media $medium ): RedirectResponse
    {
        $data = $request->validate( [
            'name'       => ['required', 'string', 'max:255'],
            'alt'        => ['nullable', 'string'],
            'collection' => ['nullable', 'string', 'max:255'],
        ] );

        $data['updated_by'] = auth()->id();

        $medium->update( $data );

        return redirect()
            ->route( 'media.index' )
            ->with( 'status', 'media-updated' );
    }

    public function destroy( Media $medium ): RedirectResponse
    {
        Storage::disk( $medium->disk )->delete( $medium->path );

        $medium->update( ['deleted_by' => auth()->id()] );
        $medium->forceDelete();

        return redirect()
            ->route( 'media.index' )
            ->with( 'status', 'media-deleted' );
    }

    /**
     * Simpan upload ke media/portal dengan nama mudah dibaca + suffix rawak (elak overwrite / clash).
     */
    private function storeUploadedFileInPortalPath( UploadedFile $file ): string
    {
        $disk = Storage::disk( 'public' );

        $originalBase = pathinfo( $file->getClientOriginalName(), PATHINFO_FILENAME );
        $slug         = Str::slug( (string) $originalBase );

        if ( $slug === '' ) {
            $slug = 'file';
        }

        $slug = Str::limit( $slug, 80, '' );

        $extension = strtolower( (string) ( $file->guessExtension() ?? $file->getClientOriginalExtension() ?? 'bin' ) );

        $directory = PortalPublicMediaPaths::PREFIX;

        do {
            $filename = $slug . '-' . Str::lower( Str::random( 8 ) ) . '.' . $extension;
            $relative = $directory . '/' . $filename;
        } while ( $disk->exists( $relative ) );

        if ( ! $disk->exists( $directory ) ) {
            $disk->makeDirectory( $directory );
        }

        $stored = $file->storeAs( $directory, $filename, 'public' );

        if ( $stored === false ) {
            abort( 500, 'Failed to store uploaded file.' );
        }

        return $stored;
    }

    /**
     * @return array<int, string>
     */
    private function getTypeOptions(): array
    {
        $parent = DataReference::query()
            ->whereNull( 'parent_id' )
            ->where( 'label_my', 'Jenis Media' )
            ->first();

        if ( ! $parent ) {
            return [];
        }

        return DataReference::query()
            ->where( 'parent_id', $parent->id )
            ->where( 'status', 1 )
            ->ordered()
            ->get()
            ->mapWithKeys( fn ( DataReference $ref ) => [$ref->id => $ref->label_my ?? $ref->label_en ?? '—'] )
            ->all();
    }
}
