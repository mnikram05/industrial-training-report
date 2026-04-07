<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\User\Models\User;
use App\Modules\Role\Constants\RolePermissionConstants;
use Modules\PortalAdministration\Models\Media;

class MediaPolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::MEDIA_VIEW );
    }

    public function view( User $user, Media $media ): bool
    {
        return $user->can( RolePermissionConstants::MEDIA_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::MEDIA_CREATE );
    }

    public function update( User $user, Media $media ): bool
    {
        return $user->can( RolePermissionConstants::MEDIA_EDIT );
    }

    public function delete( User $user, Media $media ): bool
    {
        return $user->can( RolePermissionConstants::MEDIA_DELETE );
    }
}
