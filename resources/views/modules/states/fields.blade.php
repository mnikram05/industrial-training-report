<div class="space-y-4 pb-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="state_name" :error="$errors->first('name')" class="gap-1.5">
            <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
            <x-input id="state_name" name="name" type="text" class="w-full" placeholder="{{ __('State name') }}"
                :value="old('name', $state?->name ?? '')" />
        </x-field>

        <x-field for="state_fullname" :error="$errors->first('fullname')" class="gap-1.5">
            <x-slot:labelText>{{ __('Full Name') }}</x-slot:labelText>
            <x-input id="state_fullname" name="fullname" type="text" class="w-full" placeholder="{{ __('Full name') }}"
                :value="old('fullname', $state?->fullname ?? '')" />
        </x-field>
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <x-field for="state_ddsa_code" :error="$errors->first('ddsa_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('DDSA Code') }}</x-slot:labelText>
            <x-input id="state_ddsa_code" name="ddsa_code" type="text" class="w-full" placeholder="{{ __('DDSA code') }}"
                :value="old('ddsa_code', $state?->ddsa_code ?? '')" />
        </x-field>

        <x-field for="state_iso_code" :error="$errors->first('iso_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('ISO Code') }}</x-slot:labelText>
            <x-input id="state_iso_code" name="iso_code" type="text" class="w-full" placeholder="{{ __('ISO code') }}"
                :value="old('iso_code', $state?->iso_code ?? '')" />
        </x-field>

        <x-field for="state_sort" :error="$errors->first('sort')" class="gap-1.5">
            <x-slot:labelText>{{ __('Sort Order') }}</x-slot:labelText>
            <x-input id="state_sort" name="sort" type="number" class="w-full" placeholder="{{ __('0') }}"
                :value="old('sort', $state?->sort ?? 0)" />
        </x-field>
    </div>

    <x-field for="state_status" :error="$errors->first('status')" class="gap-1.5">
        <x-slot:labelText>{{ __('Status') }}</x-slot:labelText>
        <x-select id="state_status" name="status" class="w-full sm:w-1/3"
            :options="['1' => __('Active'), '0' => __('Inactive')]"
            :value="old('status', (string) ($state?->status ?? 1))" />
    </x-field>
</div>
