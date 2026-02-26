<?php

declare(strict_types=1);

namespace App\Modules\Role\Requests;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
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
        $role   = $this->route( 'role' );
        $roleId = $role instanceof Role ? $role->getKey() : null;

        return [
            'name'          => ['required', 'string', 'max:255', Rule::unique( 'roles', 'name' )->ignore( $roleId )],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', 'distinct', Rule::exists( 'permissions', 'name' )],
        ];
    }
}
