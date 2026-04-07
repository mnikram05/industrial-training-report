<x-datatable-actions-menu>
    @can(\App\Modules\Role\Constants\RolePermissionConstants::MENUS_EDIT)
        <x-datatable-action-link :href="route('portal-administration.menus.edit', $menu)">
            {{ __('crud.edit') }}
        </x-datatable-action-link>

        @if ($menu->slug)
            <x-datatable-action-link :href="route('portal-settings.edit', ['page' => \Illuminate\Support\Str::slug($menu->slug)])">
                {{ __('crud.settings') }}
            </x-datatable-action-link>
        @endif
    @endcan

    @can(\App\Modules\Role\Constants\RolePermissionConstants::MENUS_DELETE)
        <form method="POST" action="{{ route('portal-administration.menus.destroy', $menu) }}"
            onsubmit="return confirm('{{ __('crud.are_you_sure') }}')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="hover:bg-accent hover:text-accent-foreground flex w-full items-center rounded-sm px-2 py-1.5 text-sm text-destructive">
                {{ __('crud.delete') }}
            </button>
        </form>
    @endcan
</x-datatable-actions-menu>
