<x-badge variant="{{ $landing->is_published ? 'default' : 'secondary' }}">
    {{ $landing->status->label() }}
</x-badge>
