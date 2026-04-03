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
            'filterPlaceholder' => __('ui.filter_f7c1eb'),
            'clear' => __('ui.clear'),
            'columns' => __('ui.columns'),
            'info' => __('ui.showing_start_to_end_of_total_entries'),
            'infoEmpty' => __('ui.showing_0_to_0_of_0_entries'),
            'zeroRecords' => __('ui.no_matching_records_found'),
            'emptyTable' => __('ui.no_data_available_in_table'),
            'processing' => __('ui.processing'),
            'loadingRecords' => __('ui.loading'),
            'first' => __('ui.first'),
            'previous' => __('ui.previous'),
            'next' => __('ui.next'),
            'last' => __('ui.last'),
        ];
    @endphp

    <script id="shadcn-datatables-config" type="application/json">
        @json([
            'defaultOptions' => $resolvedDefaultOptions,
            'translations' => $resolvedTranslations,
        ])
    </script>
@endonce
