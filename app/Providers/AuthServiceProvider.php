<?php

declare(strict_types=1);

namespace App\Providers;

use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\StatusPolicy;
use App\Support\Status\Status;
use App\Policies\ArticlePolicy;
use App\Policies\LandingPolicy;
use App\Modules\User\Models\User;
use Spatie\Permission\Models\Role;
use App\Policies\ActivityLogPolicy;
use Illuminate\Support\Facades\Gate;
use App\Modules\Landing\Models\Landing;
use Spatie\Activitylog\Models\Activity;
use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Models\Menu;
use Modules\PortalAdministration\Models\Media;
use App\Policies\DataReferencePolicy;
use App\Policies\MenuPolicy;
use App\Policies\MediaPolicy;
use Modules\Reference\Models\DataReference;
use App\Modules\Role\Constants\RoleNameConstants;
use App\Modules\Role\Constants\RolePermissionConstants;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class     => UserPolicy::class,
        Role::class     => RolePolicy::class,
        Status::class   => StatusPolicy::class,
        Landing::class  => LandingPolicy::class,
        Article::class  => ArticlePolicy::class,
        Menu::class     => MenuPolicy::class,
        Media::class    => MediaPolicy::class,
        Activity::class   => ActivityLogPolicy::class,
        DataReference::class => DataReferencePolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define( 'viewAuthSetup', fn ( User $user ): bool => $user->hasRole( RoleNameConstants::ADMIN ) );
        Gate::define(
            'viewAdminDashboard',
            fn ( User $user ): bool => $user->can( RolePermissionConstants::ADMIN_DASHBOARD_VIEW )
        );
    }
}
