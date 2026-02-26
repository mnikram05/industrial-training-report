<?php

declare(strict_types=1);

namespace App\Modules\Status\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusImportRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:xlsx', 'extensions:xlsx', 'max:1048576'],
        ];
    }
}
