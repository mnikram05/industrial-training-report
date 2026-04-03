@props([
    'savedStatuses' => [],
    'deletedStatuses' => [],
    'spaced' => false,
])

@php
    $attributes = $attributes->class([
        'mb-6' => $spaced,
    ]);
    $status = session('status');
    $message = null;
    $exportStatusUrl = null;

    if (in_array($status, $savedStatuses, true)) {
        $message = __('ui.saved');
    } elseif (in_array($status, $deletedStatuses, true)) {
        $message = __('ui.deleted');
    } elseif ($status === 'export-started') {
        $message = __('ui.export_started_background');
        $transferId = session('export_transfer_id');

        if (is_int($transferId) || (is_string($transferId) && ctype_digit($transferId))) {
            $exportStatusUrl = route('exports.status', ['transfer' => (int) $transferId]);
        }
    } elseif (is_string($status) && str_ends_with($status, '-imported')) {
        $message = __('Import started. The file is being processed in the background.');
    }
@endphp

@if ($message !== null)
    @if ($status === 'export-started')
        <x-alert inline data-initial-message="{{ $message }}"
            data-completed-message="{{ __('ui.export_completed_ready') }}"
            data-failed-message="{{ __('ui.export_failed_retry') }}"
            data-poll-url="{{ $exportStatusUrl ?? '' }}" x-data="{
                ready: false,
                message: '',
                downloadUrl: null,
                pollUrl: '',
                completedMessage: '',
                failedMessage: '',
                pollTimer: null,
                init() {
                    this.message = this.$el.dataset.initialMessage || '';
                    this.completedMessage = this.$el.dataset.completedMessage || this.message;
                    this.failedMessage = this.$el.dataset.failedMessage || this.message;
                    this.pollUrl = this.$el.dataset.pollUrl || '';
                    this.ready = true;
            
                    if (!this.pollUrl) {
                        return;
                    }
            
                    this.poll();
            
                    if (this.downloadUrl !== null || this.pollTimer !== null) {
                        return;
                    }
            
                    this.pollTimer = setInterval(() => {
                        this.poll();
                    }, 2000);
                },
                async poll() {
                    if (!this.pollUrl) {
                        return;
                    }
            
                    try {
                        const response = await fetch(this.pollUrl, {
                            headers: {
                                Accept: 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                        });
            
                        if (!response.ok) {
                            return;
                        }
            
                        const payload = await response.json();
            
                        if (payload.status === 'completed') {
                            this.message = this.completedMessage;
            
                            if (typeof payload.download_url === 'string' && payload.download_url !== '') {
                                this.downloadUrl = payload.download_url;
                            }
            
                            this.stop();
                            return;
                        }
            
                        if (payload.status === 'failed') {
                            this.message = this.failedMessage;
                            this.stop();
                        }
                    } catch (error) {
                        return;
                    }
                },
                stop() {
                    if (this.pollTimer !== null) {
                        clearInterval(this.pollTimer);
                        this.pollTimer = null;
                    }
                },
            }" x-init="init()"
            {{ $attributes }}>
            <x-alert-description class="m-0 whitespace-nowrap">
                <span x-show="!ready">{{ $message }}</span>
                <span x-show="ready" x-text="message"></span>
            </x-alert-description>
            <template x-if="downloadUrl !== null">
                <x-button as="a" x-bind:href="downloadUrl" size="sm" variant="secondary"
                    class="shrink-0">
                    {{ __('ui.download') }}
                </x-button>
            </template>
        </x-alert>
    @else
        <x-alert inline {{ $attributes }}>
            <x-alert-description class="m-0 whitespace-nowrap">{{ $message }}</x-alert-description>
        </x-alert>
    @endif
@endif
