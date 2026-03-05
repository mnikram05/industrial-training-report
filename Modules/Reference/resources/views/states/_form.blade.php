{{-- Shared form fields for Create / Edit --}}

<div class="space-y-4 pb-6">
    <div class="grid gap-4 sm:grid-cols-3">
        <x-field for="state_name" :error="$errors->first('name')" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/reference/state.fields.name') }} <span class="text-destructive">*</span></x-slot:labelText>
            <x-input id="state_name" name="name" type="text" class="w-full" placeholder="{{ __('modules/reference/state.fields.name') }}"
                :value="old('name', $state->name ?? '')" maxlength="100" />
        </x-field>

        <x-field for="state_fullname" :error="$errors->first('fullname')" class="gap-1.5 sm:col-span-2">
            <x-slot:labelText>{{ __('modules/reference/state.fields.fullname') }} <span class="text-destructive">*</span></x-slot:labelText>
            <x-input id="state_fullname" name="fullname" type="text" class="w-full" placeholder="{{ __('modules/reference/state.fields.fullname') }}"
                :value="old('fullname', $state->fullname ?? '')" maxlength="255" />
        </x-field>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        {{-- <x-field for="state_ddsa_code" :error="$errors->first('ddsa_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/reference/state.fields.ddsa_code') }}</x-slot:labelText>
            <x-input id="state_ddsa_code" name="ddsa_code" type="text" class="w-full" placeholder="{{ __('modules/reference/state.fields.ddsa_code') }}"
                :value="old('ddsa_code', $state->ddsa_code ?? '')" maxlength="10" />
        </x-field> --}}

        {{-- @isset($state)
        <x-field for="state_iso_code" :error="$errors->first('iso_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/reference/state.fields.iso_code') }}</x-slot:labelText>
            <x-input id="state_iso_code" name="iso_code" type="text" class="w-full" placeholder="{{ __('modules/reference/state.fields.iso_code') }}"
                :value="old('iso_code', $state->iso_code ?? '')" maxlength="10" />
        </x-field>
        @endisset --}}

        <x-field for="state_sort" :error="$errors->first('sort')" class="gap-1.5">
            <x-slot:labelText>{{ __('modules/reference/state.fields.sort') }} <span class="text-destructive">*</span></x-slot:labelText>
            <x-select id="state_sort" name="sort" class="w-full"
                :options="$sortOptions"
                :value="old('sort', $state->sort ?? 1)" />
        </x-field>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <x-field for="state_status" :error="$errors->first('status')" class="gap-1.5">
            <x-slot:labelText>{{ __('Status') }} <span class="text-destructive">*</span></x-slot:labelText>
            <x-select id="state_status" name="status" class="w-full"
                :options="['1' => __('Active'), '0' => __('Inactive')]"
                :value="old('status', $state->status ?? 1)" />
        </x-field>
    </div>
</div>
