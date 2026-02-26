@props([
    'id' => null,
    'headings' => [],
    'ajaxUrl' => null,
    'columns' => [],
    'filterPlaceholder' => null,
    'tableClass' => 'min-w-full divide-y divide-border text-sm',
])

<table id="{{ $id }}" class="{{ $tableClass }}" data-datatable="1" data-ajax-url="{{ $ajaxUrl }}"
    data-columns='@json($columns)' data-filter-placeholder="{{ $filterPlaceholder }}">
    <thead>
        <tr>
            @foreach ($headings as $heading)
                <th class="{{ $heading['class'] ?? 'px-4 py-3 text-left font-medium' }}">
                    {{ $heading['label'] ?? '' }}
                </th>
            @endforeach
        </tr>
    </thead>
</table>
