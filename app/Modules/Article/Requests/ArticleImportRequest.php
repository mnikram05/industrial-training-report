<?php

declare(strict_types=1);

namespace App\Modules\Article\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleImportRequest extends FormRequest
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
