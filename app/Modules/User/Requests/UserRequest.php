<?php

declare(strict_types=1);

namespace App\Modules\User\Requests;

use Illuminate\Validation\Rule;
use App\Modules\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Role\Constants\RoleNameConstants;
use App\Modules\User\Concerns\ProfileValidationRules;
use App\Modules\User\Concerns\PasswordValidationRules;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;
    use ProfileValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeUser         = $this->route( 'user' );
        $userKey           = $routeUser instanceof User ? $routeUser->getKey() : null;
        $userId            = is_int( $userKey ) || is_string( $userKey ) ? $userKey : null;
        $isUpdate          = $this->isMethod( 'PUT' ) || $this->isMethod( 'PATCH' );
        $authenticatedUser = $this->user();
        $isAdmin           = $authenticatedUser instanceof User
            && $authenticatedUser->hasRole( RoleNameConstants::ADMIN );

        return array_merge( $this->profileRules( $userId ), [
            'password' => $this->passwordRules( ! $isUpdate ),
            'role'     => $isAdmin
                ? ['nullable', 'string', Rule::exists( 'roles', 'name' )]
                : ['prohibited'],
        ] );
    }
}
