<?php

declare(strict_types=1);

namespace Modules\Reference\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            'parent_id' => ['nullable', 'integer', 'exists:menus,id'],
            'title_my'  => ['nullable', 'string', 'max:255'],
            'title_en'  => ['required', 'string', 'max:255'],
            'type_id'   => ['nullable', 'integer'],
            'icon'      => ['nullable', 'string', 'max:255'],
            'url'       => ['nullable', 'string', 'max:255'],
            'slug'      => ['nullable', 'string', 'max:255'],
            'sort'      => ['nullable', 'integer', 'min:0'],
            'status_id' => ['required', 'in:0,1'],
        ];
    }
}
