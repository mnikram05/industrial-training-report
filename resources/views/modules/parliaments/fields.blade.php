<div class="space-y-4 pb-6">
    <x-field for="parliament_state_id" :error="$errors->first('state_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('State') }}</x-slot:labelText>
        <x-select id="parliament_state_id" name="state_id" class="w-full sm:w-1/2"
            :options="$stateOptions"
            :value="old('state_id', (string) ($parliament?->state_id ?? ''))"
            :placeholder="__('Select a state')" />
    </x-field>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="parliament_name" :error="$errors->first('name')" class="gap-1.5">
            <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
            <x-input id="parliament_name" name="name" type="text" class="w-full" placeholder="{{ __('Parliament name') }}"
                :value="old('name', $parliament?->name ?? '')" />
        </x-field>

        <x-field for="parliament_sort" :error="$errors->first('sort')" class="gap-1.5">
            <x-slot:labelText>{{ __('Sort Order') }}</x-slot:labelText>
            <x-input id="parliament_sort" name="sort" type="number" class="w-full" placeholder="{{ __('0') }}"
                :value="old('sort', $parliament?->sort ?? 0)" />
        </x-field>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="parliament_ddsa_code" :error="$errors->first('ddsa_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('DDSA Code') }}</x-slot:labelText>
            <x-input id="parliament_ddsa_code" name="ddsa_code" type="text" class="w-full" placeholder="{{ __('DDSA code') }}"
                :value="old('ddsa_code', $parliament?->ddsa_code ?? '')" />
        </x-field>

        <x-field for="parliament_new_code" :error="$errors->first('new_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('New Code') }}</x-slot:labelText>
            <x-input id="parliament_new_code" name="new_code" type="text" class="w-full" placeholder="{{ __('New code') }}"
                :value="old('new_code', $parliament?->new_code ?? '')" />
        </x-field>
    </div>
</div>
