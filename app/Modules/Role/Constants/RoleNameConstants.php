<?php

declare(strict_types=1);

namespace App\Modules\Role\Constants;

final class RoleNameConstants
{
    public const ADMIN = 'admin';

    public const EDITOR = 'editor';

    public const VIEWER = 'viewer';

    /**
     * @return array<int, string>
     */
    public static function all(): array
    {
        return [
            self::ADMIN,
            self::EDITOR,
            self::VIEWER,
        ];
    }

    /**
     * Roles a visitor may request when self-registering (admin assigns on approval).
     *
     * @return list<string>
     */
    public static function publicRegistrationRoles(): array
    {
        return [
            self::VIEWER,
            self::EDITOR,
        ];
    }
}
