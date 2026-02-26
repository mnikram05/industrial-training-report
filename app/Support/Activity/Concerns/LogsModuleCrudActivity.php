<?php

declare(strict_types=1);

namespace App\Support\Activity\Concerns;

use App\Events\ModuleActionOccurred;
use App\Support\Activity\ActivityEvent;
use Illuminate\Database\Eloquent\Model;
use App\Support\Activity\ActivityDescription;
use Illuminate\Contracts\Auth\Authenticatable;

trait LogsModuleCrudActivity
{
    protected function logCreateAction(
        string $logName,
        string $resourceLabel,
        ?Authenticatable $causer = null,
        ?Model $subject = null,
    ): void {
        $this->logCrudAction(
            $logName,
            ActivityEvent::Created,
            ActivityDescription::create( __( $resourceLabel ) ),
            $causer,
            $subject,
        );
    }

    protected function logUpdateAction(
        string $logName,
        string $resourceLabel,
        ?Authenticatable $causer = null,
        ?Model $subject = null,
    ): void {
        $this->logCrudAction(
            $logName,
            ActivityEvent::Updated,
            ActivityDescription::edit( __( $resourceLabel ) ),
            $causer,
            $subject,
        );
    }

    protected function logDeleteAction(
        string $logName,
        string $resourceLabel,
        ?Authenticatable $causer = null,
        ?Model $subject = null,
    ): void {
        $this->logCrudAction(
            $logName,
            ActivityEvent::Deleted,
            ActivityDescription::delete( __( $resourceLabel ) ),
            $causer,
            $subject,
        );
    }

    private function logCrudAction(
        string $logName,
        ActivityEvent $event,
        string $description,
        ?Authenticatable $causer = null,
        ?Model $subject = null,
    ): void {
        ModuleActionOccurred::log(
            logName: $logName,
            event: $event,
            description: $description,
            causer: $causer,
            subject: $subject,
        );
    }
}
