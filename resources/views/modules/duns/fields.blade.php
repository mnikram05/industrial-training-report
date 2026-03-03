<div class="space-y-4 pb-6">
    <x-field for="dun_parliament_id" :error="$errors->first('parliament_id')" class="gap-1.5">
        <x-slot:labelText>{{ __('Parliament') }}</x-slot:labelText>
        <x-select id="dun_parliament_id" name="parliament_id" class="w-full sm:w-1/2"
            :options="$parliamentOptions"
            :value="old('parliament_id', (string) ($dun?->parliament_id ?? ''))"
            :placeholder="__('Select a parliament')" />
    </x-field>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="dun_name" :error="$errors->first('name')" class="gap-1.5">
            <x-slot:labelText>{{ __('Name') }}</x-slot:labelText>
            <x-input id="dun_name" name="name" type="text" class="w-full" placeholder="{{ __('DUN name') }}"
                :value="old('name', $dun?->name ?? '')" />
        </x-field>

        <x-field for="dun_sort" :error="$errors->first('sort')" class="gap-1.5">
            <x-slot:labelText>{{ __('Sort Order') }}</x-slot:labelText>
            <x-input id="dun_sort" name="sort" type="number" class="w-full" placeholder="{{ __('0') }}"
                :value="old('sort', $dun?->sort ?? 0)" />
        </x-field>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">
        <x-field for="dun_ddsa_code" :error="$errors->first('ddsa_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('DDSA Code') }}</x-slot:labelText>
            <x-input id="dun_ddsa_code" name="ddsa_code" type="text" class="w-full" placeholder="{{ __('DDSA code') }}"
                :value="old('ddsa_code', $dun?->ddsa_code ?? '')" />
        </x-field>

        <x-field for="dun_new_code" :error="$errors->first('new_code')" class="gap-1.5">
            <x-slot:labelText>{{ __('New Code') }}</x-slot:labelText>
            <x-input id="dun_new_code" name="new_code" type="text" class="w-full" placeholder="{{ __('New code') }}"
                :value="old('new_code', $dun?->new_code ?? '')" />
        </x-field>
    </div>
</div>
