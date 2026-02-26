<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Support\Activity\ActivityEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;

class ModuleActionOccurred
{
    use Dispatchable, SerializesModels;

    /**
     * @param  array<string, mixed>  $properties
     */
    public static function log(
        string $logName,
        ActivityEvent|string $event,
        string $description,
        ?Authenticatable $causer = null,
        ?Model $subject = null,
        array $properties = [],
    ): void {
        event( new self(
            logName: $logName,
            event: $event,
            description: $description,
            causer: $causer,
            subject: $subject,
            properties: $properties,
        ) );
    }

    /**
     * @param  array<string, mixed>  $properties
     */
    public function __construct(
        public string $logName,
        public ActivityEvent|string $event,
        public string $description,
        public ?Authenticatable $causer = null,
        public ?Model $subject = null,
        public array $properties = [],
    ) {}
}
