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
            'sort'      => ['required', 'integer', 'min:1'],
            'status'    => ['required', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'state_id'  => __( 'modules/reference/parliament.fields.state' ),
            'ddsa_code' => __( 'modules/reference/parliament.fields.ddsa_code' ),
            'new_code'  => __( 'modules/reference/parliament.fields.new_code' ),
            'name'      => __( 'modules/reference/parliament.fields.name' ),
            'sort'      => __( 'modules/reference/parliament.fields.sort' ),
        ];
    }
}
