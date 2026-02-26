<?php

declare(strict_types=1);

namespace App\Support\Transfer;

use App\Support\Status\Status;
use App\Support\Status\StatusType;
use App\Support\Status\StatusCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property DataTransferType $type
 * @property string $resource
 * @property int $status_id
 * @property DataTransferStatus $status
 * @property string $disk
 * @property string $path
 * @property string|null $original_filename
 * @property string $handler
 * @property string|null $initiated_by
 * @property array<string, mixed>|null $properties
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $failed_at
 * @property string|null $error_message
 */
class DataTransfer extends Model
{
    protected $table = 'data_transfers';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'resource',
        'status_id',
        'status',
        'disk',
        'path',
        'original_filename',
        'handler',
        'initiated_by',
        'properties',
        'started_at',
        'completed_at',
        'failed_at',
        'error_message',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type'         => DataTransferType::class,
            'properties'   => 'array',
            'started_at'   => 'datetime',
            'completed_at' => 'datetime',
            'failed_at'    => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Status, $this>
     */
    public function statusRecord(): BelongsTo
    {
        return $this->belongsTo( Status::class, 'status_id' );
    }

    public function getStatusAttribute(): DataTransferStatus
    {
        $statusKey = StatusCatalog::keyById( StatusType::DataTransfer, $this->status_id );

        return DataTransferStatus::tryFrom( (string) $statusKey ) ?? DataTransferStatus::Queued;
    }

    public function setStatusAttribute( DataTransferStatus|string|int|null $value ): void
    {
        if ( $value instanceof DataTransferStatus ) {
            $this->attributes['status_id'] = $value->id();

            return;
        }

        if ( is_int( $value ) && $value > 0 ) {
            $this->attributes['status_id'] = $value;

            return;
        }

        if ( is_string( $value ) ) {
            $status = DataTransferStatus::tryFrom( $value );

            if ( $status instanceof DataTransferStatus ) {
                $this->attributes['status_id'] = $status->id();

                return;
            }
        }

        $this->attributes['status_id'] = DataTransferStatus::Queued->id();
    }
}
