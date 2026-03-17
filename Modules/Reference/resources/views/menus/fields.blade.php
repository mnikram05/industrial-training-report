<div class="space-y-4 pb-6">
    <x-field for="menu_parent_id" :error="$errors->first('parent_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.parent') }}</x-slot:labelText>
        <x-select id="menu_parent_id" name="parent_id" class="sm:w-1/2"
            :options="$parentOptions"
            :value="old('parent_id', (string) ($menu?->parent_id ?? ''))"
            :placeholder="__('modules/reference/menu.placeholders.parent')" />
    </x-field>

    <x-field for="menu_title_en" :error="$errors->first('title_en')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.title_en') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-input id="menu_title_en" name="title_en" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/menu.fields.title_en') }}"
            :value="old('title_en', $menu?->title_en ?? '')" maxlength="255" />
    </x-field>

    <x-field for="menu_title_my" :error="$errors->first('title_my')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.title_my') }}</x-slot:labelText>
        <x-input id="menu_title_my" name="title_my" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/menu.fields.title_my') }}"
            :value="old('title_my', $menu?->title_my ?? '')" maxlength="255" />
    </x-field>

    <x-field for="menu_url" :error="$errors->first('url')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.url') }}</x-slot:labelText>
        <x-input id="menu_url" name="url" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/menu.fields.url') }}"
            :value="old('url', $menu?->url ?? '')" maxlength="255" />
    </x-field>

    <x-field for="menu_slug" :error="$errors->first('slug')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.slug') }}</x-slot:labelText>
        <x-input id="menu_slug" name="slug" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/menu.fields.slug') }}"
            :value="old('slug', $menu?->slug ?? '')" maxlength="255" />
    </x-field>

    <x-field for="menu_icon" :error="$errors->first('icon')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.icon') }}</x-slot:labelText>
        <x-input id="menu_icon" name="icon" type="text" class="sm:w-1/2" placeholder="{{ __('modules/reference/menu.fields.icon') }}"
            :value="old('icon', $menu?->icon ?? '')" maxlength="255" />
    </x-field>

    <x-field for="menu_sort" :error="$errors->first('sort')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.sort') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="menu_sort" name="sort" class="sm:w-1/2"
            :options="$sortOptions"
            :value="old('sort', $menu?->sort ?? 1)" />
    </x-field>

    <x-field for="menu_status_id" :error="$errors->first('status_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('modules/reference/menu.fields.status') }} <span class="text-destructive">*</span></x-slot:labelText>
        <x-select id="menu_status_id" name="status_id" class="sm:w-1/2"
            :options="['1' => __('crud.active'), '0' => __('crud.inactive')]"
            :value="old('status_id', $menu?->status_id ?? 1)" />
    </x-field>
</div>
