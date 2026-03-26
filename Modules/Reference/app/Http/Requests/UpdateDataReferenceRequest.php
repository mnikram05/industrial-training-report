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
            'label_my'    => ['nullable', 'string', 'max:255'],
            'label_en'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
