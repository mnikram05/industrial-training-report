<?php

declare(strict_types=1);

namespace App\Modules\Article\Requests;

use Illuminate\Validation\Rule;
use App\Support\Status\StatusType;
use App\Modules\Article\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Article\Enums\ArticleStatusEnum;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $article   = $this->route( 'article' );
        $articleId = $article instanceof Article ? $article->getKey() : null;

        return [
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', Rule::unique( 'articles', 'slug' )->ignore( $articleId )],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'content'      => ['required', 'string'],
            'status_id'    => ['nullable', 'integer', Rule::exists( 'statuses', 'id' )->where( 'type', StatusType::Article->value )],
            'status'       => ['nullable', Rule::enum( ArticleStatusEnum::class )],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
