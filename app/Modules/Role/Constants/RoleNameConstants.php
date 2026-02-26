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
}
