<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistrictRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'state_id'  => ['required', 'integer', 'exists:zz_states,id'],
            'ddsa_code' => ['nullable', 'string', 'max:20', 'unique:zz_districts,ddsa_code'],
            'name'      => ['required', 'string', 'max:255'],
            'fullname'  => ['nullable', 'string', 'max:255'],
            'sort'      => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'state_id'  => __( 'modules/reference/district.fields.state' ),
            'ddsa_code' => __( 'modules/reference/district.fields.ddsa_code' ),
            'name'      => __( 'modules/reference/district.fields.name' ),
            'fullname'  => __( 'modules/reference/district.fields.fullname' ),
            'sort'      => __( 'modules/reference/district.fields.sort' ),
        ];
    }
}
