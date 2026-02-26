@once
    <template id="dt-progress-template">
        <div class="w-full">
            <x-progress :value="100" class="h-1.5 w-full animate-pulse" />
        </div>
    </template>

    @php
        $resolvedDefaultOptions = is_array($dataTableDefaultOptions ?? null)
            ? $dataTableDefaultOptions
            : [
                'processing' => false,
                'serverSide' => true,
                'lengthChange' => false,
                'pagingType' => 'simple_numbers',
                'scrollX' => false,
            ];

        $resolvedTranslations = [
            'filterPlaceholder' => __('Filter...'),
            'clear' => __('Clear'),
            'columns' => __('Columns'),
            'info' => __('Showing _START_ to _END_ of _TOTAL_ entries'),
            'infoEmpty' => __('Showing 0 to 0 of 0 entries'),
            'zeroRecords' => __('No matching records found'),
            'emptyTable' => __('No data available in table'),
            'processing' => __('Processing...'),
            'loadingRecords' => __('Loading...'),
            'first' => __('First'),
            'previous' => __('Previous'),
            'next' => __('Next'),
            'last' => __('Last'),
        ];
    @endphp

    <script id="shadcn-datatables-config" type="application/json">
        @json([
            'defaultOptions' => $resolvedDefaultOptions,
            'translations' => $resolvedTranslations,
        ])
    </script>
@endonce
