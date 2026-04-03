<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('users.show', $user)">
        {{ __('ui.view') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('users.edit', $user)">
        {{ __('ui.edit') }}
    </x-datatable-action-link>

    @if ($canImpersonate)
        <x-datatable-action-link :href="route('impersonate', $user->getKey())">
            {{ __('ui.impersonate') }}
        </x-datatable-action-link>
    @endif
</x-datatable-actions-menu>
