<div class="space-y-4">
    <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.icon_emoji') }}</x-slot:labelText>
        <select x-model="block.data.icon" class="h-9 w-40 rounded-md border border-input bg-background px-3 text-sm">
            <option value="">--</option>
            @foreach (['👤' => 'Person','🏢' => 'Building','📅' => 'Calendar','🎓' => 'Graduation','📄' => 'Document','📋' => 'Clipboard','📈' => 'Chart','⭐' => 'Star','🏆' => 'Trophy','🚀' => 'Rocket','💡' => 'Idea','👥' => 'Group','👁️' => 'Eye','⚙️' => 'Gear','📱' => 'Mobile','🖥️' => 'Desktop','🚩' => 'Flag','⬆️' => 'Up','📌' => 'Pin','🔗' => 'Link','✅' => 'Check','❤️' => 'Heart','📝' => 'Note','🔍' => 'Search'] as $emoji => $label)
                <option value="{{ $emoji }}">{{ $emoji }} {{ $label }}</option>
            @endforeach
        </select></x-field>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_ms') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_ms" /></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.title_en') }}</x-slot:labelText>
            <x-input type="text" x-model="block.data.heading_en" /></x-field>
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.desc_ms') }}</x-slot:labelText>
            <textarea x-model="block.data.text_ms" rows="4" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm"></textarea></x-field>
        <x-field class="gap-1.5"><x-slot:labelText>{{ __('modules/portal/setting.fields.desc_en') }}</x-slot:labelText>
            <textarea x-model="block.data.text_en" rows="4" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm"></textarea></x-field>
    </div>
</div>
