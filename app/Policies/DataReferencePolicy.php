<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\Role\Constants\RolePermissionConstants;
use App\Modules\User\Models\User;
use Modules\Reference\Models\DataReference;

class DataReferencePolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::DATA_REFERENCES_VIEW );
    }

    public function view( User $user, DataReference $dataReference ): bool
    {
        return $user->can( RolePermissionConstants::DATA_REFERENCES_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::DATA_REFERENCES_CREATE );
    }

    public function update( User $user, DataReference $dataReference ): bool
    {
        return $user->can( RolePermissionConstants::DATA_REFERENCES_EDIT );
    }

    public function delete( User $user, DataReference $dataReference ): bool
    {
        return $user->can( RolePermissionConstants::DATA_REFERENCES_DELETE );
    }
}
