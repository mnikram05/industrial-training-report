<div class="space-y-4 pb-6">
    <x-field for="article_title" :error="$errors->first('title')" class="gap-1.5">
        <x-slot:labelText>{{ __('Title') }}</x-slot:labelText>
        <x-input id="article_title" name="title" type="text" class="w-full" placeholder="{{ __('Article title') }}"
            :value="old('title', $article?->title ?? '')" />
    </x-field>

    <x-field for="article_slug" :error="$errors->first('slug')" class="gap-1.5">
        <x-slot:labelText>{{ __('Slug') }}</x-slot:labelText>
        <x-input id="article_slug" name="slug" type="text" class="w-full" placeholder="{{ __('article-slug') }}"
            :value="old('slug', $article?->slug ?? '')" />
    </x-field>

    <x-field for="article_excerpt" :error="$errors->first('excerpt')" class="gap-1.5">
        <x-slot:labelText>{{ __('Excerpt') }}</x-slot:labelText>
        <x-textarea id="article_excerpt" name="excerpt" class="min-h-24 w-full"
            placeholder="{{ __('Article excerpt') }}">{{ old('excerpt', $article?->excerpt ?? '') }}</x-textarea>
    </x-field>

    <x-field for="article_content" :error="$errors->first('content')" class="gap-1.5">
        <x-slot:labelText>{{ __('Content') }}</x-slot:labelText>
        <x-textarea id="article_content" name="content" class="min-h-40 w-full"
            placeholder="{{ __('Article content') }}">{{ old('content', $article?->content ?? '') }}</x-textarea>
    </x-field>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="article_status_id" :error="$errors->first('status_id')" class="gap-1.5">
            <x-slot:labelText>{{ __('Status') }}</x-slot:labelText>
            <x-select id="article_status_id" name="status_id" class="w-full" :options="$articleStatusOptions ?? []" :value="old(
                'status_id',
                $article?->status_id ?? \App\Modules\Article\Enums\ArticleStatusEnum::default()->id(),
            )" />
        </x-field>

        <x-field for="article_published_at" :error="$errors->first('published_at')" class="gap-1.5">
            <x-slot:labelText>{{ __('Published At') }}</x-slot:labelText>
            <x-date-picker id="article_published_at" name="published_at" mode="datetime-local" class="w-full"
                :value="old('published_at', $article?->published_at?->format('Y-m-d\TH:i'))" placeholder="{{ __('Pick publish date and time') }}" />
        </x-field>
    </div>
</div>
