<?php

declare(strict_types=1);

namespace App\Modules\AdminDashboard\Services;

use Closure;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use App\Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use Modules\Reference\Models\State;
use Illuminate\Support\Facades\Cache;
use App\Support\Activity\ActivityEvent;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Query\JoinClause;
use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Enums\ArticleStatusEnum;

class AdminDashboardService
{
    /**
     * @var array{total_users: int, total_articles: int, published_articles: int, total_roles: int}|null
     */
    private ?array $overviewStats = null;

    /**
     * Get total user count.
     */
    public function getTotalUsers(): int
    {
        return $this->getOverviewStats()['total_users'];
    }

    /**
     * Get total article count.
     */
    public function getTotalArticles(): int
    {
        return $this->getOverviewStats()['total_articles'];
    }

    /**
     * Get published article count.
     */
    public function getPublishedArticles(): int
    {
        return $this->getOverviewStats()['published_articles'];
    }

    /**
     * Get total role count.
     */
    public function getTotalRoles(): int
    {
        return $this->getOverviewStats()['total_roles'];
    }

    /**
     * @return list<array{role: string, users: int, color: string}>
     */
    public function getUserRoleDistribution(): array
    {
        /** @var list<array{role: string, users: int, color: string}> $distribution */
        $distribution = $this->rememberValue(
            'admin-dashboard:user-role-distribution',
            [120, 600],
            fn (): array => $this->buildUserRoleDistribution(),
        );

        return $distribution;
    }

    /**
     * @return list<array{id: int, title: string, description: string, time: string, url: string, initial: string}>
     */
    public function getLatestActivityItems( int $limit = 5 ): array
    {
        $safeLimit = max( 1, $limit );

        /** @var list<array{id: int, title: string, description: string, time: string, url: string, initial: string}> $items */
        $items = $this->rememberValue(
            'admin-dashboard:latest-activity-items:' . $safeLimit,
            [30, 180],
            fn (): array => $this->buildLatestActivityItems( $safeLimit ),
        );

        return $items;
    }

    /**
     * @return list<array{name: string, count: int}>
     */
    public function getActivityByCategory(): array
    {
        /** @var list<array{name: string, count: int}> $categories */
        $categories = $this->rememberValue(
            'admin-dashboard:activity-by-category',
            [120, 600],
            fn (): array => $this->buildActivityByCategory(),
        );

        return $categories;
    }

    /**
     * @return list<array{id: int, name: string}>
     */
    public function getState(): array
    {
        /** @var list<array{id: int, name: string}> $states */
        $states = $this->rememberValue(
            'admin-dashboard:states',
            [120, 600],
            fn (): array => State::query()
                ->where( 'status', true )
                ->ordered()
                ->get( ['id', 'name'] )
                ->map( fn ( State $state ): array => [
                    'id'   => $state->id,
                    'name' => $state->name,
                ] )
                ->values()
                ->all(),
        );

        return $states;
    }

    /**
     * @return array<int, array{date: string, login: int, logout: int}>
     */
    public function getAuthenticationActivityByDay( int $days = 90 ): array
    {
        $range = max( 1, $days );

        /** @var array<int, array{date: string, login: int, logout: int}> $series */
        $series = $this->rememberValue(
            'admin-dashboard:auth-activity-by-day:' . $range,
            [300, 900],
            fn (): array => $this->buildAuthenticationActivityByDay( $range ),
        );

        return $series;
    }

    /**
     * @return list<array{role: string, users: int, color: string}>
     */
    private function buildUserRoleDistribution(): array
    {
        $palette = [
            '#3b82f6',
            '#14b8a6',
            '#f59e0b',
            '#8b5cf6',
            '#ef4444',
            '#06b6d4',
        ];

        $roles = Role::query()
            ->leftJoin( 'model_has_roles', function ( JoinClause $join ): void {
                $join->on( 'roles.id', '=', 'model_has_roles.role_id' )
                    ->where( 'model_has_roles.model_type', User::class );
            } )
            ->select( 'roles.name' )
            ->selectRaw( 'COUNT(model_has_roles.model_id) as users_count' )
            ->groupBy( 'roles.id', 'roles.name' )
            ->orderByDesc( 'users_count' )
            ->get()
            ->values()
            ->all();

        $distribution = [];

        foreach ( $roles as $index => $role ) {
            $usersCountValue = data_get( $role, 'users_count' );
            $usersCount      = is_numeric( $usersCountValue ) ? (int) $usersCountValue : 0;

            $distribution[] = [
                'role' => Str::of( (string) $role->name )
                    ->replace( ['-', '_'], ' ' )
                    ->title()
                    ->value(),
                'users' => $usersCount,
                'color' => $palette[$index % count( $palette )],
            ];
        }

        return $distribution;
    }

    /**
     * @return list<array{id: int, title: string, description: string, time: string, url: string, initial: string}>
     */
    private function buildLatestActivityItems( int $limit ): array
    {
        $activityLogsLabel = __( 'ui.activity_logs' );
        $systemLabel       = __( 'ui.system' );
        $unknownLabel      = __( 'ui.unknown' );
        $fallbackTitle     = is_string( $activityLogsLabel ) ? $activityLogsLabel : 'Activity Logs';
        $fallbackActor     = is_string( $systemLabel ) ? $systemLabel : 'System';
        $fallbackTime      = is_string( $unknownLabel ) ? $unknownLabel : 'Unknown';

        $activities = Activity::query()
            ->select( ['id', 'description', 'event', 'causer_type', 'causer_id', 'created_at'] )
            ->with( 'causer:id,name' )
            ->latest()
            ->limit( $limit )
            ->get()
            ->values()
            ->all();

        $items = [];

        foreach ( $activities as $activity ) {
            $descriptionValue = data_get( $activity, 'description' );
            $eventValue       = data_get( $activity, 'event' );
            $causerNameValue  = data_get( $activity, 'causer.name' );
            $idValue          = $activity->getKey();
            $timeValue        = $activity->created_at?->diffForHumans();
            $description      = is_string( $descriptionValue ) ? trim( $descriptionValue ) : '';
            $event            = is_string( $eventValue ) ? trim( $eventValue ) : '';
            $causerName       = is_string( $causerNameValue ) ? trim( $causerNameValue ) : '';
            $title            = $description !== ''
                ? $description
                : ( $event !== '' ? Str::headline( $event ) : $fallbackTitle );
            $actor   = $causerName !== '' ? $causerName : $fallbackActor;
            $time    = is_string( $timeValue ) && $timeValue !== '' ? $timeValue : $fallbackTime;
            $id      = is_numeric( $idValue ) ? (int) $idValue : 0;
            $initial = Str::upper( Str::substr( $actor, 0, 1 ) );

            $items[] = [
                'id'          => $id,
                'title'       => $title,
                'description' => $actor,
                'time'        => $time,
                'url'         => route( 'activity-logs.show', $activity ),
                'initial'     => $initial !== '' ? $initial : 'S',
            ];
        }

        return $items;
    }

    /**
     * @return list<array{name: string, count: int}>
     */
    private function buildActivityByCategory(): array
    {
        $results = Activity::query()
            ->toBase()
            ->selectRaw( 'log_name, COUNT(*) as total' )
            ->groupBy( 'log_name' )
            ->orderByDesc( 'total' )
            ->get();

        $categories = [];

        foreach ( $results as $row ) {
            $logName = data_get( $row, 'log_name' );
            $total   = data_get( $row, 'total' );

            if ( ! is_string( $logName ) || $logName === '' ) {
                continue;
            }

            $categories[] = [
                'name'  => Str::of( $logName )->replace( ['-', '_'], ' ' )->title()->value(),
                'count' => is_numeric( $total ) ? (int) $total : 0,
            ];
        }

        return $categories;
    }

    /**
     * @return array<int, array{date: string, login: int, logout: int}>
     */
    private function buildAuthenticationActivityByDay( int $range ): array
    {
        $endDate   = CarbonImmutable::now()->startOfDay();
        $startDate = $endDate->subDays( $range - 1 );

        /** @var \Illuminate\Support\Collection<int, object{activity_date: string, event: string, total: int|string}> $activityByDateAndEvent */
        $activityByDateAndEvent = Activity::query()
            ->toBase()
            ->selectRaw( 'DATE(created_at) as activity_date' )
            ->selectRaw( 'event' )
            ->selectRaw( 'COUNT(*) as total' )
            ->where( 'log_name', 'auth' )
            ->whereIn( 'event', [
                ActivityEvent::LoggedIn->value,
                ActivityEvent::LoggedOut->value,
            ] )
            ->whereBetween( 'created_at', [$startDate, $endDate->endOfDay()] )
            ->groupBy( 'activity_date', 'event' )
            ->get();

        $lookup = [];

        foreach ( $activityByDateAndEvent as $item ) {
            $dateValue  = data_get( $item, 'activity_date' );
            $eventValue = data_get( $item, 'event' );
            $totalValue = data_get( $item, 'total' );

            if ( ! is_string( $dateValue ) || $dateValue === '' ) {
                continue;
            }

            if ( ! is_string( $eventValue ) || $eventValue === '' ) {
                continue;
            }

            $lookup[$dateValue][$eventValue] = is_numeric( $totalValue ) ? (int) $totalValue : 0;
        }

        $series = [];
        $cursor = $startDate;

        while ( $cursor->lessThanOrEqualTo( $endDate ) ) {
            $date = $cursor->toDateString();

            $series[] = [
                'date'   => $date,
                'login'  => (int) ( $lookup[$date][ActivityEvent::LoggedIn->value] ?? 0 ),
                'logout' => (int) ( $lookup[$date][ActivityEvent::LoggedOut->value] ?? 0 ),
            ];

            $cursor = $cursor->addDay();
        }

        return $series;
    }

    /**
     * @return array{total_users: int, total_articles: int, published_articles: int, total_roles: int}
     */
    private function getOverviewStats(): array
    {
        if ( is_array( $this->overviewStats ) ) {
            return $this->overviewStats;
        }

        /** @var array{total_users: int, total_articles: int, published_articles: int, total_roles: int} $overviewStats */
        $overviewStats = $this->rememberValue(
            'admin-dashboard:overview-stats',
            [30, 180],
            fn (): array => $this->calculateOverviewStats(),
        );

        $this->overviewStats = $overviewStats;

        return $overviewStats;
    }

    /**
     * @return array{total_users: int, total_articles: int, published_articles: int, total_roles: int}
     */
    private function calculateOverviewStats(): array
    {
        $overviewStats = Role::query()
            ->selectRaw( 'COUNT(*) as total_roles' )
            ->selectSub( User::query()->selectRaw( 'COUNT(*)' ), 'total_users' )
            ->selectSub( Article::query()->selectRaw( 'COUNT(*)' ), 'total_articles' )
            ->selectSub(
                Article::query()
                    ->selectRaw( 'COUNT(*)' )
                    ->where( 'status_id', ArticleStatusEnum::Published->id() ),
                'published_articles'
            )
            ->first();

        return [
            'total_users' => is_numeric( data_get( $overviewStats, 'total_users' ) )
                ? (int) data_get( $overviewStats, 'total_users' )
                : 0,
            'total_articles' => is_numeric( data_get( $overviewStats, 'total_articles' ) )
                ? (int) data_get( $overviewStats, 'total_articles' )
                : 0,
            'published_articles' => is_numeric( data_get( $overviewStats, 'published_articles' ) )
                ? (int) data_get( $overviewStats, 'published_articles' )
                : 0,
            'total_roles' => is_numeric( data_get( $overviewStats, 'total_roles' ) )
                ? (int) data_get( $overviewStats, 'total_roles' )
                : 0,
        ];
    }

    /**
     * @param  array{int, int}  $windows
     * @param  Closure(): mixed  $resolver
     */
    private function rememberValue( string $key, array $windows, Closure $resolver ): mixed
    {
        if ( app()->environment( 'testing' ) ) {
            return $resolver();
        }

        $cached = Cache::flexible( $key, $windows, $resolver );

        return $cached;
    }
}
