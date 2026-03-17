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
                        const table = window.jQuery('#parliaments-table').DataTable();
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
