<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::USERS_VIEW)
        <x-datatable-action-link :href="route('users.show', $user)">
            {{ __('ui.view') }}
        </x-datatable-action-link>
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::USERS_EDIT)
        <x-datatable-action-link :href="route('users.edit', $user)">
            {{ __('ui.edit') }}
        </x-datatable-action-link>
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::USERS_APPROVE)
        @if ($user->isPendingRegistrationApproval())
            <form method="POST" action="{{ route('users.approve', $user) }}"
                onsubmit="return confirm('{{ __('modules/login.register.confirm_approve') }}')">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="hover:bg-accent hover:text-accent-foreground flex w-full items-center rounded-sm px-2 py-1.5 text-sm">
                    {{ __('modules/login.register.approve') }}
                </button>
            </form>
        @endif
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::USERS_APPROVE)
        @if ($user->isPendingRegistrationApproval())
            <form method="POST" action="{{ route('users.reject', $user) }}"
                onsubmit="return confirm('{{ __('modules/login.register.confirm_reject') }}')">
                @csrf
                @method('PATCH')
                <button type="submit"
                    class="hover:bg-accent hover:text-accent-foreground flex w-full items-center rounded-sm px-2 py-1.5 text-sm text-destructive">
                    {{ __('modules/login.register.reject') }}
                </button>
            </form>
        @endif
    @endcan

    @if ($canImpersonate)
        <x-datatable-action-link :href="route('impersonate', $user->getKey())">
            {{ __('ui.impersonate') }}
        </x-datatable-action-link>
    @endif
</x-datatable-actions-menu>
