<?php

declare(strict_types=1);

namespace App\Modules\Auth\Services;

use Carbon\CarbonImmutable;
use App\Modules\User\Models\User;
use App\Support\Activity\ActivityEvent;
use Spatie\Activitylog\Models\Activity;
use App\Modules\Auth\Dtos\AccountProfileDto;
use App\Support\Activity\Concerns\LogsModuleCrudActivity;

class AccountService
{
    use LogsModuleCrudActivity;

    private const LOG_NAME = 'auth';

    private const RESOURCE_LABEL = 'Account';

    /**
     * @return list<array{month: string, desktop: int}>
     */
    public function getLoginActivityByMonth( User $user, int $months = 6 ): array
    {
        $range      = max( 1, $months );
        $endMonth   = CarbonImmutable::now()->startOfMonth();
        $startMonth = $endMonth->subMonths( $range - 1 );

        /** @var array<string, int> $countsByMonth */
        $countsByMonth = Activity::query()
            ->select( ['created_at'] )
            ->where( 'log_name', 'auth' )
            ->where( 'event', ActivityEvent::LoggedIn->value )
            ->where( 'causer_type', User::class )
            ->where( 'causer_id', $user->getKey() )
            ->whereBetween( 'created_at', [$startMonth, $endMonth->endOfMonth()] )
            ->get()
            ->reduce( function ( array $carry, Activity $activity ): array {
                $createdAt = $activity->created_at;

                if ( ! $createdAt instanceof \Carbon\CarbonInterface ) {
                    return $carry;
                }

                $monthKey         = CarbonImmutable::instance( $createdAt )->startOfMonth()->toDateString();
                $currentCount     = $carry[$monthKey] ?? 0;
                $currentCount     = is_int( $currentCount ) ? $currentCount : 0;
                $carry[$monthKey] = $currentCount + 1;

                return $carry;
            }, [] );

        $series = [];
        $cursor = $startMonth;

        while ( $cursor->lessThanOrEqualTo( $endMonth ) ) {
            $monthKey = $cursor->toDateString();

            $series[] = [
                'month'   => $cursor->isoFormat( 'MMM YYYY' ),
                'desktop' => (int) ( $countsByMonth[$monthKey] ?? 0 ),
            ];

            $cursor = $cursor->addMonth();
        }

        return $series;
    }

    public function updateProfile( User $user, AccountProfileDto $data ): User
    {
        $user->fill( [
            'name'  => $data->name,
            'email' => $data->email,
        ] );

        if ( $user->isDirty( 'email' ) ) {
            $user->email_verified_at = null;
        }

        $user->save();
        $user = $user->refresh();

        $this->logUpdateAction( self::LOG_NAME, self::RESOURCE_LABEL, $user, $user );

        return $user;
    }

    public function deleteAccount( User $user ): bool
    {
        $deleted = (bool) $user->delete();

        if ( $deleted ) {
            $this->logDeleteAction( self::LOG_NAME, self::RESOURCE_LABEL, $user, $user );
        }

        return $deleted;
    }
}
