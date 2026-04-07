/**
 * After PATCH sort on .sort-btn, reload the surrounding DataTable via AJAX.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.sort-btn');
        if (!btn) {
            return;
        }

        e.preventDefault();
        btn.disabled = true;

        const url = btn.dataset.url;
        const direction = btn.dataset.direction;
        const tableEl = btn.closest('table');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

        if (!url || !tableEl?.id) {
            btn.disabled = false;

            return;
        }

        fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                Accept: 'application/json',
            },
            body: JSON.stringify({ direction }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (!data.success || typeof window.jQuery === 'undefined' || typeof window.jQuery.fn.DataTable === 'undefined') {
                    return;
                }

                const $ = window.jQuery;
                const selector = `#${CSS.escape(tableEl.id)}`;

                if ($.fn.dataTable.isDataTable(selector)) {
                    $(selector).DataTable().ajax.reload(null, false);
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            })
            .finally(() => {
                btn.disabled = false;
            });
    });
});
