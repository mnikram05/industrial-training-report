<?php

declare(strict_types=1);

namespace App\Support\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class ModuleActivityLogger
{
    /**
     * @param  array<string, mixed>  $properties
     */
    public function log(
        ?Authenticatable $causer,
        string $logName,
        ActivityEvent|string $event,
        string $description,
        ?Model $subject = null,
        array $properties = []
    ): void {
        if ( ! $causer instanceof Model ) {
            return;
        }

        $logger = activity( $logName )
            ->causedBy( $causer )
            ->event( $event instanceof ActivityEvent ? $event->value : $event );

        if ( $subject instanceof Model ) {
            $logger->performedOn( $subject );
        }

        if ( $properties !== [] ) {
            $logger->withProperties( $properties );
        }

        $logger->log( $description );
    }
}
