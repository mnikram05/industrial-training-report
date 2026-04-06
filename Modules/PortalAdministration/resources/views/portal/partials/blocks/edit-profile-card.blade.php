<div class="space-y-4">
    {{-- Photo --}}
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.select_photo') }}</x-slot:labelText>
        <select x-model="block.data.photo_path" class="w-full h-9 rounded-md border border-input bg-background px-3 text-sm sm:w-1/2">
            <option value="">-- {{ __('modules/portal/setting.messages.none') }} --</option>
            <template x-for="[path, label] in Object.entries(mediaOptions)" :key="path"><option :value="path" x-text="label" :selected="block.data.photo_path === path"></option></template>
        </select>
        <p class="text-xs text-muted-foreground">{{ __('modules/portal/setting.hints.upload_media_first') }}</p>
    </x-field>

    {{-- Name & Student ID --}}
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.full_name') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.nama" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.student_id') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.no_pelajar" /></x-field>
    </div>

    {{-- Programme --}}
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.programme') }}</x-slot:labelText>
        <x-input type="text" x-model="block.data.program" /></x-field>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.programme_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.program_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.programme_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.program_en" /></x-field>
    </div>

    {{-- Training Session & Internship Period --}}
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.training_session') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.sesi_latihan" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.internship_period') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.tempoh_li" /></x-field>
    </div>

    {{-- Date of Birth & Phone --}}
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.date_of_birth') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.tarikh_lahir" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.phone') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.telefon" /></x-field>
    </div>

    {{-- Email --}}
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.email') }}</x-slot:labelText>
        <x-input type="email" x-model="block.data.email" /></x-field>

    {{-- Address --}}
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.address') }}</x-slot:labelText>
        <x-input type="text" x-model="block.data.alamat" /></x-field>
</div>
