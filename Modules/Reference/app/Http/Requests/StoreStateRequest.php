<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ddsa_code' => ['nullable', 'string', 'max:10', 'unique:zz_states,ddsa_code'],
            'name'      => ['required', 'string', 'max:100'],
            'fullname'  => ['nullable', 'string', 'max:255'],
            'iso_code'  => ['nullable', 'string', 'max:10', 'unique:zz_states,iso_code'],
            'sort'      => ['nullable', 'integer', 'min:0'],
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
