<?php

declare(strict_types=1);

namespace App\Policies;

use App\Modules\User\Models\User;
use App\Modules\Article\Models\Article;
use App\Modules\Role\Constants\RolePermissionConstants;

class ArticlePolicy
{
    public function viewAny( User $user ): bool
    {
        return $user->can( RolePermissionConstants::ARTICLES_VIEW );
    }

    public function view( User $user, Article $article ): bool
    {
        return $user->can( RolePermissionConstants::ARTICLES_VIEW );
    }

    public function create( User $user ): bool
    {
        return $user->can( RolePermissionConstants::ARTICLES_CREATE );
    }

    public function update( User $user, Article $article ): bool
    {
        return $user->can( RolePermissionConstants::ARTICLES_EDIT );
    }

    public function delete( User $user, Article $article ): bool
    {
        return $user->can( RolePermissionConstants::ARTICLES_DELETE );
    }

    public function publish( User $user, Article $article ): bool
    {
        return $user->can( RolePermissionConstants::ARTICLES_PUBLISH );
    }
}
