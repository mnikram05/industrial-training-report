<div class="space-y-4 pb-6" x-data="{
    menuTypeId: '{{ old('menu_type_id', $article?->menu_type_id ?? '') }}',
    menuOptions: @js($menuOptions ?? []),
    documentTypeId: '{{ old('document_type_id', $article?->document_type_id ?? '') }}',
    documentTypeKontentId: '{{ $documentTypeKontentId ?? '' }}',
    documentTypeDokumenId: '{{ $documentTypeDokumenId ?? '' }}',
    async loadMenus() {
        if (!this.menuTypeId) {
            this.menuOptions = {};
            return;
        }
        try {
            const response = await fetch('/api/menus-by-type/' + this.menuTypeId);
            const data = await response.json();
            const options = {};
            data.forEach(m => { options[m.id] = m.title_my || m.title_en || '—'; });
            this.menuOptions = options;
        } catch (e) {
            this.menuOptions = {};
        }
    }
}">
    <x-field for="article_menu_type_id" :error="$errors->first('menu_type_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/portal-administration/article.fields.menu_type') }}</x-slot:labelText>
        <select id="article_menu_type_id" name="menu_type_id" class="sm:w-1/2 h-9 rounded-md border border-input bg-background px-3 text-sm"
            x-model="menuTypeId" @change="loadMenus()">
            <option value="">{{ __('modules/portal-administration/article.placeholders.select_menu_type') }}</option>
            @foreach ($menuTypeOptions ?? [] as $id => $label)
                <option value="{{ $id }}">{{ $label }}</option>
            @endforeach
        </select>
    </x-field>

    <x-field for="article_menu_id" :error="$errors->first('menu_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/portal-administration/article.fields.menu') }}</x-slot:labelText>
        <select id="article_menu_id" name="menu_id" class="sm:w-1/2 h-9 rounded-md border border-input bg-background px-3 text-sm">
            <option value="">{{ __('modules/portal-administration/article.placeholders.select_menu') }}</option>
            <template x-for="(label, id) in menuOptions" :key="id">
                <option :value="id" x-text="label"
                    :selected="id == '{{ old('menu_id', $article?->menu_id ?? '') }}'"></option>
            </template>
        </select>
    </x-field>

    <x-field for="article_title_my" :error="$errors->first('title_my')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/portal-administration/article.fields.title_my') }}</x-slot:labelText>
        <x-input id="article_title_my" name="title_my" type="text" class="sm:w-1/2" placeholder="{{ __('modules/portal-administration/article.placeholders.title_my') }}"
            :value="old('title_my', $article?->title_my ?? '')" maxlength="255" />
    </x-field>

    <x-field for="article_title_en" :error="$errors->first('title_en')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/portal-administration/article.fields.title_en') }}</x-slot:labelText>
        <x-input id="article_title_en" name="title_en" type="text" class="sm:w-1/2" placeholder="{{ __('modules/portal-administration/article.placeholders.title_en') }}"
            :value="old('title_en', $article?->title_en ?? '')" maxlength="255" />
    </x-field>

    <x-field for="article_document_type_id" :error="$errors->first('document_type_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/portal-administration/article.fields.document_type') }}</x-slot:labelText>
        <select id="article_document_type_id" name="document_type_id" class="sm:w-1/2 h-9 rounded-md border border-input bg-background px-3 text-sm"
            x-model="documentTypeId">
            <option value="">{{ __('modules/portal-administration/article.placeholders.select_document_type') }}</option>
            @foreach ($documentTypeOptions ?? [] as $id => $label)
                <option value="{{ $id }}">{{ $label }}</option>
            @endforeach
        </select>
    </x-field>

    {{-- Kontent fields --}}
    <template x-if="documentTypeId == documentTypeKontentId">
        <div class="space-y-4">
            <x-field for="article_title" :error="$errors->first('title')" class="gap-1.5">
                <x-slot:labelText>{{ __('modules/portal-administration/article.fields.title') }} <span class="text-destructive">*</span></x-slot:labelText>
                <x-input id="article_title" name="title" type="text" class="w-full" placeholder="{{ __('modules/portal-administration/article.placeholders.title') }}"
                    :value="old('title', $article?->title ?? '')" />
            </x-field>

            <x-field for="article_slug" :error="$errors->first('slug')" class="gap-1.5">
                <x-slot:labelText>{{ __('modules/portal-administration/article.fields.slug') }}</x-slot:labelText>
                <x-input id="article_slug" name="slug" type="text" class="w-full" placeholder="{{ __('modules/portal-administration/article.placeholders.slug') }}"
                    :value="old('slug', $article?->slug ?? '')" />
            </x-field>

            <x-field for="article_excerpt" :error="$errors->first('excerpt')" class="gap-1.5">
                <x-slot:labelText>{{ __('modules/portal-administration/article.fields.excerpt') }}</x-slot:labelText>
                <x-textarea id="article_excerpt" name="excerpt" class="min-h-24 w-full"
                    placeholder="{{ __('modules/portal-administration/article.placeholders.excerpt') }}">{{ old('excerpt', $article?->excerpt ?? '') }}</x-textarea>
            </x-field>

            <x-field for="article_content" :error="$errors->first('content')" class="gap-1.5">
                <x-slot:labelText>{{ __('modules/portal-administration/article.fields.content') }}</x-slot:labelText>
                <x-textarea id="article_content" name="content" class="min-h-40 w-full"
                    placeholder="{{ __('modules/portal-administration/article.placeholders.content') }}">{{ old('content', $article?->content ?? '') }}</x-textarea>
            </x-field>
        </div>
    </template>

    {{-- Dokumen fields --}}
    <template x-if="documentTypeId == documentTypeDokumenId">
        <div class="space-y-4">
            <x-field for="article_title" :error="$errors->first('title')" class="gap-1.5">
                <x-slot:labelText>{{ __('modules/portal-administration/article.fields.title') }} <span class="text-destructive">*</span></x-slot:labelText>
                <x-input id="article_title_doc" name="title" type="text" class="w-full" placeholder="{{ __('modules/portal-administration/article.placeholders.title_doc') }}"
                    :value="old('title', $article?->title ?? '')" />
            </x-field>

            <x-field for="article_file" :error="$errors->first('file')" class="gap-1.5">
                <x-slot:labelText>{{ __('modules/portal-administration/article.fields.file') }} <span class="text-destructive">*</span></x-slot:labelText>
                <input id="article_file" name="file" type="file" accept=".pdf"
                    class="sm:w-1/2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary file:text-primary-foreground hover:file:bg-primary/90" />
                <p class="text-xs text-muted-foreground">{{ __('modules/portal-administration/article.messages.pdf_only') }}</p>

                @if ($article?->file_path)
                    <p class="text-sm text-muted-foreground mt-1">
                        {{ __('modules/portal-administration/article.messages.current_file') }}
                        <a href="{{ Storage::disk('public')->url($article->file_path) }}" target="_blank" class="text-primary underline">
                            {{ basename($article->file_path) }}
                        </a>
                    </p>
                @endif
            </x-field>
        </div>
    </template>

    <x-field for="article_status_id" :error="$errors->first('status_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/portal-administration/article.fields.status') }}</x-slot:labelText>
        <x-select id="article_status_id" name="status_id" class="sm:w-1/2" :options="$articleStatusOptions ?? []" :value="old(
            'status_id',
            $article?->status_id ?? \Modules\PortalAdministration\Enums\ArticleStatusEnum::default()->id(),
        )" />
    </x-field>

    <x-field for="article_published_at" :error="$errors->first('published_at')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/portal-administration/article.fields.published_at') }}</x-slot:labelText>
        <x-date-picker id="article_published_at" name="published_at" mode="datetime-local" class="sm:w-1/2"
            :value="old('published_at', $article?->published_at?->format('Y-m-d\TH:i'))" placeholder="{{ __('modules/portal-administration/article.placeholders.published_at') }}" />
    </x-field>
</div>
