<?php

declare(strict_types=1);

namespace App\Modules\Role\Constants;

final class RolePermissionConstants
{
    public const USERS_VIEW = 'users.view';

    public const USERS_CREATE = 'users.create';

    public const USERS_EDIT = 'users.edit';

    public const USERS_DELETE = 'users.delete';

    public const ARTICLES_VIEW = 'articles.view';

    public const ARTICLES_CREATE = 'articles.create';

    public const ARTICLES_EDIT = 'articles.edit';

    public const ARTICLES_DELETE = 'articles.delete';

    public const ARTICLES_PUBLISH = 'articles.publish';

    public const ROLES_VIEW = 'roles.view';

    public const ROLES_CREATE = 'roles.create';

    public const ROLES_EDIT = 'roles.edit';

    public const ROLES_DELETE = 'roles.delete';

    public const LANDINGS_VIEW = 'landings.view';

    public const LANDINGS_CREATE = 'landings.create';

    public const LANDINGS_EDIT = 'landings.edit';

    public const LANDINGS_DELETE = 'landings.delete';

    public const STATUSES_VIEW = 'statuses.view';

    public const STATUSES_CREATE = 'statuses.create';

    public const STATUSES_EDIT = 'statuses.edit';

    public const STATUSES_DELETE = 'statuses.delete';

    public const ACTIVITY_LOGS_VIEW = 'activity-logs.view';

    public const ADMIN_DASHBOARD_VIEW = 'admin-dashboard.view';

    /**
     * @return array<int, string>
     */
    public static function all(): array
    {
        return [
            self::USERS_VIEW,
            self::USERS_CREATE,
            self::USERS_EDIT,
            self::USERS_DELETE,
            self::ARTICLES_VIEW,
            self::ARTICLES_CREATE,
            self::ARTICLES_EDIT,
            self::ARTICLES_DELETE,
            self::ARTICLES_PUBLISH,
            self::ROLES_VIEW,
            self::ROLES_CREATE,
            self::ROLES_EDIT,
            self::ROLES_DELETE,
            self::LANDINGS_VIEW,
            self::LANDINGS_CREATE,
            self::LANDINGS_EDIT,
            self::LANDINGS_DELETE,
            self::STATUSES_VIEW,
            self::STATUSES_CREATE,
            self::STATUSES_EDIT,
            self::STATUSES_DELETE,
            self::ACTIVITY_LOGS_VIEW,
            self::ADMIN_DASHBOARD_VIEW,
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function forAdmin(): array
    {
        return self::all();
    }

    /**
     * @return array<int, string>
     */
    public static function forEditor(): array
    {
        return [
            self::ARTICLES_VIEW,
            self::ARTICLES_CREATE,
            self::ARTICLES_EDIT,
            self::ARTICLES_DELETE,
            self::ARTICLES_PUBLISH,
            self::LANDINGS_VIEW,
            self::LANDINGS_CREATE,
            self::LANDINGS_EDIT,
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function forViewer(): array
    {
        return [
            self::USERS_VIEW,
            self::ARTICLES_VIEW,
        ];
    }
}
