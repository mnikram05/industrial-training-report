<x-app-layout>
    <x-module-index-shell>
        <x-slot:heading>{{ $dataReference->label_ms ?? $dataReference->name }} — {{ __('modules/reference/data-reference.children_list') }}</x-slot:heading>
        <x-slot:subtitle>{{ __('modules/reference/data-reference.children_subtitle') }}</x-slot:subtitle>

        <x-slot:actions>
            <a href="{{ route('reference.data-references.index') }}">
                <x-button variant="secondary">{{ __('crud.back') }}</x-button>
            </a>
            <a href="{{ route('reference.data-references.children.create', $dataReference) }}">
                <x-button>{{ __('modules/reference/data-reference.create_child') }}</x-button>
            </a>
        </x-slot:actions>

        <div class="w-full">
            {!! $dataTable->table() !!}
        </div>

        @push('scripts')
            {!! $dataTable->scripts() !!}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.addEventListener('click', function(e) {
                        const btn = e.target.closest('.sort-btn');
                        if (!btn) return;

                        e.preventDefault();
                        btn.disabled = true;

                        const url = btn.dataset.url;
                        const direction = btn.dataset.direction;

                        fetch(url, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({ direction: direction })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const table = window.jQuery('#child-data-references-table').DataTable();
                                table.ajax.reload(null, false);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        })
                        .finally(() => {
                            btn.disabled = false;
                        });
                    });
                });
            </script>
        @endpush
    </x-module-index-shell>
</x-app-layout>
