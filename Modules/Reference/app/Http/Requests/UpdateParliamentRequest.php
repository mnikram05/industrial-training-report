<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParliamentRequest extends FormRequest
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
        $parliamentId = $this->route( 'parliament' )->id ?? $this->route( 'parliament' );

        return [
            'state_id'  => ['required', 'integer', 'exists:zz_states,id'],
            'ddsa_code' => ['nullable', 'string', 'max:20', Rule::unique( 'zz_parliaments', 'ddsa_code' )->ignore( $parliamentId )],
            'new_code'  => ['nullable', 'string', 'max:20'],
            'name'      => ['required', 'string', 'max:255'],
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
            'new_code'  => __( 'New Code' ),
            'name'      => __( 'Parliament Name' ),
            'sort'      => __( 'Sort Order' ),
        ];
    }
}
