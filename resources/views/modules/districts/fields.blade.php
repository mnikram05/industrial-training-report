<div class="space-y-4 pb-6">
    <x-field for="district_state_id" :error="$errors->first('state_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('State') }}</x-slot:labelText>
        <x-select id="district_state_id" name="state_id" class="w-full sm:w-1/2"
            :options="$stateOptions"
            :value="old('state_id', (string) ($district?->state_id ?? ''))"
            :placeholder="__('Select a state')" />
    </x-field>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="district_name" :error="$errors->first('name')" class="gap-1.5">
            <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
            <x-input id="district_name" name="name" type="text" class="w-full" placeholder="{{ __('District name') }}"
                :value="old('name', $district?->name ?? '')" />
        </x-field>

        <x-field for="district_fullname" :error="$errors->first('fullname')" class="gap-1.5">
            <x-slot:labelText>{{ __('Full Name') }}</x-slot:labelText>
            <x-input id="district_fullname" name="fullname" type="text" class="w-full" placeholder="{{ __('Full name') }}"
                :value="old('fullname', $district?->fullname ?? '')" />
        </x-field>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="district_ddsa_code" :error="$errors->first('ddsa_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('DDSA Code') }}</x-slot:labelText>
            <x-input id="district_ddsa_code" name="ddsa_code" type="text" class="w-full" placeholder="{{ __('DDSA code') }}"
                :value="old('ddsa_code', $district?->ddsa_code ?? '')" />
        </x-field>

        <x-field for="district_sort" :error="$errors->first('sort')" class="gap-1.5">
            <x-slot:labelText>{{ __('Sort Order') }}</x-slot:labelText>
            <x-input id="district_sort" name="sort" type="number" class="w-full" placeholder="{{ __('0') }}"
                :value="old('sort', $district?->sort ?? 0)" />
        </x-field>
    </div>
</div>
