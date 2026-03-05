<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use App\Rules\NoScript;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $stateId = $this->route( 'state' )->id ?? $this->route( 'state' );

        return [
            'ddsa_code' => ['nullable', 'string', 'max:10', Rule::unique( 'zz_states', 'ddsa_code' )->ignore( $stateId )],
            'name'      => ['required', 'string', 'max:100', new NoScript],
            'fullname'  => ['required', 'string', 'max:255', new NoScript],
            'iso_code'  => ['nullable', 'string', 'max:10', Rule::unique( 'zz_states', 'iso_code' )->ignore( $stateId )],
            'sort'      => ['required', 'integer', 'min:0'],
            'status'    => ['required', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'ddsa_code' => 'DDSA Code',
            'name'      => 'State Name',
            'fullname'  => 'Full Name',
            'iso_code'  => 'ISO Code',
            'sort'      => 'Sort Order',
            'status'    => 'Status',
        ];
    }
}
