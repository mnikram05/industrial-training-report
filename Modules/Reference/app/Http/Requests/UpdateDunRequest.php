<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDunRequest extends FormRequest
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
        $dunId = $this->route( 'dun' )->id ?? $this->route( 'dun' );

        return [
            'parliament_id' => ['required', 'integer', 'exists:zz_parliaments,id'],
            'ddsa_code'     => ['nullable', 'string', 'max:20', Rule::unique( 'zz_duns', 'ddsa_code' )->ignore( $dunId )],
            'new_code'      => ['nullable', 'string', 'max:20'],
            'name'          => ['required', 'string', 'max:255'],
            'sort'          => ['nullable', 'integer', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'parliament_id' => __( 'Parliament' ),
            'ddsa_code'     => __( 'DDSA Code' ),
            'new_code'      => __( 'New Code' ),
            'name'          => __( 'DUN Name' ),
            'sort'          => __( 'Sort Order' ),
        ];
    }
}
