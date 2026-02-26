<x-datatable-actions-menu>
    <x-datatable-action-link :href="route('users.show', $user)">
        {{ __('View') }}
    </x-datatable-action-link>

    <x-datatable-action-link :href="route('users.edit', $user)">
        {{ __('Edit') }}
    </x-datatable-action-link>

    @if ($canImpersonate)
        <x-datatable-action-link :href="route('impersonate', $user->getKey())">
            {{ __('Impersonate') }}
        </x-datatable-action-link>
    @endif
</x-datatable-actions-menu>
