<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Modules\Reference\Models\DataReference;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Media extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'type_id',
        'name',
        'file_name',
        'mime_type',
        'path',
        'disk',
        'size',
        'collection',
        'alt',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly( $this->fillable )
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk( $this->disk )->url( $this->path );
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = $this->size;

        if ( $bytes >= 1048576 ) {
            return round( $bytes / 1048576, 2 ) . ' MB';
        }

        if ( $bytes >= 1024 ) {
            return round( $bytes / 1024, 2 ) . ' KB';
        }

        return $bytes . ' B';
    }

    public function isImage(): bool
    {
        return str_starts_with( (string) $this->mime_type, 'image/' );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo( DataReference::class, 'type_id' );
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'created_by' );
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'updated_by' );
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo( User::class, 'deleted_by' );
    }

    public function scopeSearch( Builder $query, ?string $term ): Builder
    {
        if ( ! $term ) {
            return $query;
        }

        return $query->where( function ( Builder $q ) use ( $term ) {
            $q->where( 'name', 'like', "%{$term}%" )
                ->orWhere( 'file_name', 'like', "%{$term}%" );
        } );
    }
}
