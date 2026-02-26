<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\ModuleActionOccurred;
use App\Support\Activity\ModuleActivityLogger;

class LogModuleAction
{
    public function __construct(
        protected ModuleActivityLogger $activityLogger
    ) {}

    public function handle( ModuleActionOccurred $event ): void
    {
        $this->activityLogger->log(
            $event->causer,
            $event->logName,
            $event->event,
            $event->description,
            $event->subject,
            $event->properties,
        );
    }
}
