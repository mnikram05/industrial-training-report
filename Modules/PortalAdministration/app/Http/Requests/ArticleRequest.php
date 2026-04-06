<?php

declare(strict_types=1);

namespace Modules\PortalAdministration\Http\Requests;

use Illuminate\Validation\Rule;
use App\Support\Status\StatusType;
use Illuminate\Foundation\Http\FormRequest;
use Modules\PortalAdministration\Models\Article;
use Modules\PortalAdministration\Enums\ArticleStatusEnum;

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
            'menu_type_id'     => ['nullable', 'integer', 'exists:menus,id'],
            'menu_id'          => ['nullable', 'integer', 'exists:menus,id'],
            'title_ms'         => ['nullable', 'string', 'max:255'],
            'title_en'         => ['nullable', 'string', 'max:255'],
            'document_type_id' => ['nullable', 'integer', 'exists:zz_data_references,id'],
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255', Rule::unique( 'articles', 'slug' )->ignore( $articleId )],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['nullable', 'string'],
            'file'             => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'status_id'        => ['nullable', 'integer', Rule::exists( 'statuses', 'id' )->where( 'type', StatusType::Article->value )],
            'status'           => ['nullable', Rule::enum( ArticleStatusEnum::class )],
            'published_at'     => ['nullable', 'date'],
        ];
    }
}
