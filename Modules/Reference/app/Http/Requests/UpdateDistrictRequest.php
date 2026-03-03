<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDistrictRequest extends FormRequest
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
        $districtId = $this->route( 'district' )->id ?? $this->route( 'district' );

        return [
            'state_id'  => ['required', 'integer', 'exists:zz_states,id'],
            'ddsa_code' => ['nullable', 'string', 'max:20', Rule::unique( 'zz_districts', 'ddsa_code' )->ignore( $districtId )],
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
            'state_id'  => __( 'State' ),
            'ddsa_code' => __( 'DDSA Code' ),
            'name'      => __( 'District Name' ),
            'fullname'  => __( 'Full Name' ),
            'sort'      => __( 'Sort Order' ),
        ];
    }
}
