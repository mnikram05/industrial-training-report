<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataReferenceRequest extends FormRequest
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
            'parent_id' => ['nullable', 'integer', 'exists:zz_data_references,id'],
            'label_my'  => ['nullable', 'string', 'max:255'],
            'label_en'  => ['nullable', 'string', 'max:255'],
            'name'      => ['required', 'string', 'max:255'],
            'sort'      => ['nullable', 'integer', 'min:0'],
            'status'    => ['required', 'in:0,1'],
        ];
    }
}
