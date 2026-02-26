<?php

declare(strict_types=1);

namespace App\Modules\Landing\Requests;

use Illuminate\Validation\Rule;
use App\Support\Status\StatusType;
use App\Modules\Landing\Models\Landing;
use Illuminate\Foundation\Http\FormRequest;

class LandingRequest extends FormRequest
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
        $landing   = $this->route( 'landing' );
        $landingId = $landing instanceof Landing ? $landing->getKey() : null;

        return [
            'title'                                 => ['nullable', 'string', 'max:255'],
            'slug'                                  => ['nullable', 'string', 'max:255', Rule::unique( 'landings', 'slug' )->ignore( $landingId )],
            'content'                               => ['nullable', 'array'],
            'content.hero'                          => ['nullable', 'array'],
            'content.hero.title'                    => ['nullable'],
            'content.hero.title.en'                 => ['nullable', 'string', 'max:255'],
            'content.hero.title.ms'                 => ['nullable', 'string', 'max:255'],
            'content.hero.subtitle'                 => ['nullable'],
            'content.hero.subtitle.en'              => ['nullable', 'string', 'max:500'],
            'content.hero.subtitle.ms'              => ['nullable', 'string', 'max:500'],
            'content.hero.primary_button'           => ['nullable', 'array'],
            'content.hero.primary_button.text'      => ['nullable'],
            'content.hero.primary_button.text.en'   => ['nullable', 'string', 'max:50'],
            'content.hero.primary_button.text.ms'   => ['nullable', 'string', 'max:50'],
            'content.hero.primary_button.url'       => ['nullable', 'string', 'max:255'],
            'content.hero.secondary_button'         => ['nullable', 'array'],
            'content.hero.secondary_button.text'    => ['nullable'],
            'content.hero.secondary_button.text.en' => ['nullable', 'string', 'max:50'],
            'content.hero.secondary_button.text.ms' => ['nullable', 'string', 'max:50'],
            'content.hero.secondary_button.url'     => ['nullable', 'string', 'max:255'],
            'content.banner'                        => ['nullable', 'array'],
            'content.banner.title'                  => ['nullable'],
            'content.banner.title.en'               => ['nullable', 'string', 'max:255'],
            'content.banner.title.ms'               => ['nullable', 'string', 'max:255'],
            'content.banner.subtitle'               => ['nullable'],
            'content.banner.subtitle.en'            => ['nullable', 'string', 'max:500'],
            'content.banner.subtitle.ms'            => ['nullable', 'string', 'max:500'],
            'content.banner.image'                  => ['nullable', 'image', 'max:5120'],
            'content.banner.alt'                    => ['nullable'],
            'content.banner.alt.en'                 => ['nullable', 'string', 'max:255'],
            'content.banner.alt.ms'                 => ['nullable', 'string', 'max:255'],
            'content.about'                         => ['nullable', 'array'],
            'content.about.title'                   => ['nullable'],
            'content.about.title.en'                => ['nullable', 'string', 'max:255'],
            'content.about.title.ms'                => ['nullable', 'string', 'max:255'],
            'content.about.body'                    => ['nullable'],
            'content.about.body.en'                 => ['nullable', 'string', 'max:2000'],
            'content.about.body.ms'                 => ['nullable', 'string', 'max:2000'],
            'content.about.image'                   => ['nullable', 'image', 'max:5120'],
            'content.about.alt'                     => ['nullable'],
            'content.about.alt.en'                  => ['nullable', 'string', 'max:255'],
            'content.about.alt.ms'                  => ['nullable', 'string', 'max:255'],
            'content.security'                      => ['nullable', 'array'],
            'content.security.title'                => ['nullable'],
            'content.security.title.en'             => ['nullable', 'string', 'max:255'],
            'content.security.title.ms'             => ['nullable', 'string', 'max:255'],
            'content.security.body'                 => ['nullable'],
            'content.security.body.en'              => ['nullable', 'string', 'max:2000'],
            'content.security.body.ms'              => ['nullable', 'string', 'max:2000'],
            'content.security.image'                => ['nullable', 'image', 'max:5120'],
            'content.security.alt'                  => ['nullable'],
            'content.security.alt.en'               => ['nullable', 'string', 'max:255'],
            'content.security.alt.ms'               => ['nullable', 'string', 'max:255'],
            'content.articles'                      => ['nullable', 'array', 'max:3'],
            'content.articles.*.article_slug'       => ['nullable', 'string', 'max:255'],
            'content.articles.*.title'              => ['nullable'],
            'content.articles.*.title.en'           => ['nullable', 'string', 'max:255'],
            'content.articles.*.title.ms'           => ['nullable', 'string', 'max:255'],
            'content.articles.*.excerpt'            => ['nullable'],
            'content.articles.*.excerpt.en'         => ['nullable', 'string', 'max:500'],
            'content.articles.*.excerpt.ms'         => ['nullable', 'string', 'max:500'],
            'content.articles.*.image'              => ['nullable', 'image', 'max:5120'],
            'content.articles.*.alt'                => ['nullable'],
            'content.articles.*.alt.en'             => ['nullable', 'string', 'max:255'],
            'content.articles.*.alt.ms'             => ['nullable', 'string', 'max:255'],
            'content.features'                      => ['nullable', 'array', 'max:3'],
            'content.features.*.icon'               => ['nullable', 'string', Rule::in( ['sparkles', 'shield', 'globe', 'zap', 'heart', 'star'] )],
            'content.features.*.title'              => ['nullable'],
            'content.features.*.title.en'           => ['nullable', 'string', 'max:100'],
            'content.features.*.title.ms'           => ['nullable', 'string', 'max:100'],
            'content.features.*.description'        => ['nullable'],
            'content.features.*.description.en'     => ['nullable', 'string', 'max:255'],
            'content.features.*.description.ms'     => ['nullable', 'string', 'max:255'],
            'content.footer'                        => ['nullable', 'array'],
            'content.footer.text'                   => ['nullable'],
            'content.footer.text.en'                => ['nullable', 'string', 'max:255'],
            'content.footer.text.ms'                => ['nullable', 'string', 'max:255'],
            'status_id'                             => ['nullable', 'integer', Rule::exists( 'statuses', 'id' )->where( 'type', StatusType::Landing->value )],
            'is_published'                          => ['sometimes', 'boolean'],
        ];
    }
}
