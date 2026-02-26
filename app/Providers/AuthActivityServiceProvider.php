<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\User\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Events\ModuleActionOccurred;
use Illuminate\Support\Facades\Event;
use App\Support\Activity\ActivityEvent;
use Illuminate\Support\ServiceProvider;
use App\Support\Activity\ActivityDescription;
use Lab404\Impersonate\Events\TakeImpersonation;
use Lab404\Impersonate\Events\LeaveImpersonation;

class AuthActivityServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen( Login::class, function ( Login $event ): void {
            if ( ! $event->user instanceof User ) {
                return;
            }

            ModuleActionOccurred::log(
                logName: 'auth',
                event: ActivityEvent::LoggedIn,
                description: ActivityDescription::login(),
                causer: $event->user,
                subject: $event->user,
            );
        } );

        Event::listen( Logout::class, function ( Logout $event ): void {
            if ( ! $event->user instanceof User ) {
                return;
            }

            ModuleActionOccurred::log(
                logName: 'auth',
                event: ActivityEvent::LoggedOut,
                description: ActivityDescription::logout(),
                causer: $event->user,
                subject: $event->user,
            );
        } );

        Event::listen( TakeImpersonation::class, function ( TakeImpersonation $event ): void {
            if ( ! $event->impersonator instanceof User || ! $event->impersonated instanceof User ) {
                return;
            }

            ModuleActionOccurred::log(
                logName: 'users',
                event: ActivityEvent::Impersonated,
                description: ActivityDescription::impersonate(),
                causer: $event->impersonator,
                subject: $event->impersonated,
                properties: [
                    'impersonator_id' => $event->impersonator->getKey(),
                    'impersonated_id' => $event->impersonated->getKey(),
                ],
            );
        } );

        Event::listen( LeaveImpersonation::class, function ( LeaveImpersonation $event ): void {
            if ( ! $event->impersonator instanceof User || ! $event->impersonated instanceof User ) {
                return;
            }

            ModuleActionOccurred::log(
                logName: 'users',
                event: ActivityEvent::ImpersonationLeft,
                description: ActivityDescription::impersonation(),
                causer: $event->impersonator,
                subject: $event->impersonated,
                properties: [
                    'impersonator_id' => $event->impersonator->getKey(),
                    'impersonated_id' => $event->impersonated->getKey(),
                ],
            );
        } );
    }
}
