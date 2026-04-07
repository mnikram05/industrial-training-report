<?php

declare(strict_types=1);

namespace App\Modules\Auth\Requests;

use Illuminate\Validation\Rules;
use App\Modules\User\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Role\Constants\RoleNameConstants;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'max:255'],
            'email'            => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique( User::class, 'email' )->whereNull( 'deleted_at' ),
            ],
            'password'         => ['required', 'confirmed', Rules\Password::defaults()],
            'requested_role'   => ['required', 'string', Rule::in( RoleNameConstants::publicRegistrationRoles() )],
        ];
    }
}
