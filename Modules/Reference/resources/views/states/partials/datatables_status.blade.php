<form method="POST" action="{{ route('reference.states.toggle-status', $state) }}"
    class="inline-flex">
    @csrf
    @method('PATCH')
    <button type="submit"
        class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium transition-colors {{ $state->status ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20 hover:bg-green-100 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20 dark:hover:bg-green-500/20' : 'bg-gray-50 text-gray-600 ring-1 ring-inset ring-gray-500/10 hover:bg-gray-100 dark:bg-gray-400/10 dark:text-gray-400 dark:ring-gray-400/20 dark:hover:bg-gray-400/20' }}">
        {{ $state->status ? __('crud.active') : __('crud.inactive') }}
    </button>
</form>
