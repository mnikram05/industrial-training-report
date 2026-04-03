<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <x-field for="landing_slug" :error="$errors->first('slug')" class="gap-1.5">
        <x-slot:labelText>{{ __('ui.slug') }}</x-slot:labelText>
        <x-input id="landing_slug" name="slug" type="text" class="w-full" placeholder="{{ __('ui.e_g_landing') }}"
            :value="old('slug', $landing?->slug ?? '')" />
    </x-field>

    <x-field for="landing_status_id" :error="$errors->first('status_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('ui.status') }}</x-slot:labelText>
        <x-select id="landing_status_id" name="status_id" class="w-full" :options="$landingStatusOptions ?? []" :value="old(
            'status_id',
            $landing?->status_id ?? \App\Modules\Landing\Enums\LandingStatusEnum::default()->id(),
        )" />
    </x-field>
</div>
