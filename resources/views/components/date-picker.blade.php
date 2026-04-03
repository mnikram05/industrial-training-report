@props([
    'value' => null,
    'mode' => 'date',
    'placeholder' => __('ui.select_date'),
])

@php
    $id = $attributes->get('id');
    $name = $attributes->get('name');
    $disabled = $attributes->has('disabled');
    $rootClass = trim((string) $attributes->get('class', ''));
    $inputMode = in_array($mode, ['date', 'datetime-local'], true) ? $mode : 'date';
    $currentValue = is_scalar($value) ? (string) $value : '';
    $pickerId =
        is_string($id) && $id !== ''
            ? $id
            : ($name
                ? str_replace(['[', ']', '.'], '_', (string) $name)
                : 'date_picker_' . substr(md5(uniqid((string) random_int(0, 999999), true)), 0, 8));
@endphp

<div x-data="{
    open: false,
    panelPlacement: 'bottom',
    monthMenuOpen: false,
    yearMenuOpen: false,
    mode: @js($inputMode),
    placeholder: @js($placeholder),
    monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    weekdays: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    selectedDate: null,
    selectedTime: '00:00',
    month: 0,
    year: 0,
    days: [],
    initialValue: @js($currentValue),
    init() {
        const today = new Date();
        this.month = today.getMonth();
        this.year = today.getFullYear();

        if (this.initialValue) {
            const parsed = this.parseInitialValue(this.initialValue);

            if (parsed !== null) {
                this.selectedDate = parsed.date;
                this.month = parsed.date.getMonth();
                this.year = parsed.date.getFullYear();

                if (parsed.time !== null && parsed.time !== '') {
                    this.selectedTime = parsed.time;
                }
            }
        }

        this.buildCalendar();
    },
    togglePanel() {
        this.open = !this.open;
        this.monthMenuOpen = false;
        this.yearMenuOpen = false;

        if (this.open) {
            this.$nextTick(() => this.updatePanelPlacement());
        }
    },
    closePanel() {
        this.open = false;
        this.monthMenuOpen = false;
        this.yearMenuOpen = false;
    },
    updatePanelPlacement() {
        if (!this.$refs.trigger) {
            return;
        }

        const rect = this.$refs.trigger.getBoundingClientRect();
        const estimatedHeight = this.mode === 'datetime-local' ? 430 : 360;
        const spaceBelow = window.innerHeight - rect.bottom;
        const spaceAbove = rect.top;

        this.panelPlacement = (spaceBelow < estimatedHeight && spaceAbove > spaceBelow) ?
            'top' :
            'bottom';
    },
    parseInitialValue(rawValue) {
        if (typeof rawValue !== 'string' || rawValue.trim() === '') {
            return null;
        }

        if (this.mode === 'datetime-local') {
            const [datePart, timePart = '00:00'] = rawValue.split('T');
            const date = this.parseDatePart(datePart);

            if (date === null) {
                return null;
            }

            return {
                date,
                time: timePart.slice(0, 5),
            };
        }

        const date = this.parseDatePart(rawValue);

        if (date === null) {
            return null;
        }

        return {
            date,
            time: null,
        };
    },
    parseDatePart(datePart) {
        if (typeof datePart !== 'string') {
            return null;
        }

        const segments = datePart.split('-');

        if (segments.length !== 3) {
            return null;
        }

        const year = Number(segments[0]);
        const month = Number(segments[1]);
        const day = Number(segments[2]);

        if (!Number.isInteger(year) || !Number.isInteger(month) || !Number.isInteger(day)) {
            return null;
        }

        const candidate = new Date(year, month - 1, day);

        if (
            candidate.getFullYear() !== year ||
            candidate.getMonth() !== month - 1 ||
            candidate.getDate() !== day
        ) {
            return null;
        }

        return candidate;
    },
    buildCalendar() {
        const firstDay = new Date(this.year, this.month, 1);
        const firstWeekday = firstDay.getDay();
        const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
        const daysInPreviousMonth = new Date(this.year, this.month, 0).getDate();
        const generatedDays = [];

        for (let index = 0; index < 42; index++) {
            let displayDay;
            let displayMonth = this.month;
            let displayYear = this.year;
            let outside = false;

            if (index < firstWeekday) {
                displayDay = daysInPreviousMonth - firstWeekday + index + 1;
                displayMonth = this.month - 1;
                outside = true;
            } else if (index >= firstWeekday + daysInMonth) {
                displayDay = index - (firstWeekday + daysInMonth) + 1;
                displayMonth = this.month + 1;
                outside = true;
            } else {
                displayDay = index - firstWeekday + 1;
            }

            if (displayMonth < 0) {
                displayMonth = 11;
                displayYear -= 1;
            }

            if (displayMonth > 11) {
                displayMonth = 0;
                displayYear += 1;
            }

            generatedDays.push({
                day: displayDay,
                month: displayMonth,
                year: displayYear,
                outside,
            });
        }

        this.days = generatedDays;
    },
    previousMonth() {
        this.monthMenuOpen = false;
        this.yearMenuOpen = false;

        if (this.month === 0) {
            this.month = 11;
            this.year -= 1;
        } else {
            this.month -= 1;
        }

        this.buildCalendar();
    },
    nextMonth() {
        this.monthMenuOpen = false;
        this.yearMenuOpen = false;

        if (this.month === 11) {
            this.month = 0;
            this.year += 1;
        } else {
            this.month += 1;
        }

        this.buildCalendar();
    },
    yearOptions() {
        const now = new Date().getFullYear();
        const startYear = now - 40;
        const endYear = now + 40;
        const years = [];

        for (let year = startYear; year <= endYear; year++) {
            years.push(year);
        }

        return years;
    },
    selectMonth(monthIndex) {
        this.month = monthIndex;
        this.monthMenuOpen = false;
        this.buildCalendar();
    },
    selectYear(yearValue) {
        this.year = yearValue;
        this.yearMenuOpen = false;
        this.buildCalendar();
    },
    selectDay(dayObject) {
        this.selectedDate = new Date(dayObject.year, dayObject.month, dayObject.day);
        this.month = dayObject.month;
        this.year = dayObject.year;
        this.monthMenuOpen = false;
        this.yearMenuOpen = false;
        this.buildCalendar();

        if (this.mode === 'date') {
            this.open = false;
        }
    },
    isToday(dayObject) {
        const today = new Date();

        return today.getDate() === dayObject.day &&
            today.getMonth() === dayObject.month &&
            today.getFullYear() === dayObject.year;
    },
    isSelected(dayObject) {
        if (this.selectedDate === null) {
            return false;
        }

        return this.selectedDate.getDate() === dayObject.day &&
            this.selectedDate.getMonth() === dayObject.month &&
            this.selectedDate.getFullYear() === dayObject.year;
    },
    hiddenValue() {
        if (this.selectedDate === null) {
            return '';
        }

        const year = this.selectedDate.getFullYear();
        const month = String(this.selectedDate.getMonth() + 1).padStart(2, '0');
        const day = String(this.selectedDate.getDate()).padStart(2, '0');
        const datePart = `${year}-${month}-${day}`;

        if (this.mode === 'datetime-local') {
            const timePart = this.selectedTime && this.selectedTime.length >= 4 ?
                this.selectedTime.slice(0, 5) :
                '00:00';

            return `${datePart}T${timePart}`;
        }

        return datePart;
    },
    displayValue() {
        if (this.selectedDate === null) {
            return this.placeholder;
        }

        const dateLabel = new Intl.DateTimeFormat(undefined, {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
        }).format(this.selectedDate);

        if (this.mode === 'datetime-local') {
            const [hours = '00', minutes = '00'] = (this.selectedTime || '00:00').split(':');
            const combined = new Date(
                this.selectedDate.getFullYear(),
                this.selectedDate.getMonth(),
                this.selectedDate.getDate(),
                Number(hours) || 0,
                Number(minutes) || 0
            );

            const timeLabel = new Intl.DateTimeFormat(undefined, {
                hour: '2-digit',
                minute: '2-digit',
            }).format(combined);

            return `${dateLabel} ${timeLabel}`;
        }

        return dateLabel;
    },
    clear() {
        this.selectedDate = null;
        this.selectedTime = '00:00';
    },
}" class="{{ trim('relative w-full ' . $rootClass) }}" @keydown.escape.window="closePanel()"
    @resize.window="open && updatePanelPlacement()" @scroll.window="open && updatePanelPlacement()">
    @if ($name)
        <input type="hidden" name="{{ $name }}" :value="hiddenValue()">
    @endif

    <button type="button" id="{{ $pickerId }}" x-ref="trigger"
        class="border-input bg-background focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 aria-invalid:border-destructive inline-flex h-9 w-full items-center justify-between rounded-md border px-3 py-1 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:ring-[3px] disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50"
        @click="togglePanel()" :aria-expanded="open.toString()" aria-haspopup="dialog" @disabled($disabled)>
        <span class="truncate" :class="selectedDate ? 'text-foreground' : 'text-muted-foreground'"
            x-text="displayValue()"></span>
        <svg class="size-4 opacity-60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="3" y="4" width="18" height="18" rx="2" />
            <path d="M16 2v4M8 2v4M3 10h18" />
        </svg>
    </button>

    <div x-show="open" x-cloak :class="panelPlacement === 'top' ? 'bottom-full mb-1' : 'top-full mt-1'"
        x-transition.origin.top.left @click.outside="closePanel()"
        class="bg-popover text-popover-foreground absolute left-0 z-50 w-[19rem] rounded-md border p-3 shadow-md">
        <div class="mb-3 flex items-center justify-between gap-2">
            <button type="button"
                class="inline-flex size-8 items-center justify-center rounded-md hover:bg-accent hover:text-accent-foreground"
                @click="previousMonth()">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                </svg>
            </button>

            <div class="relative flex items-center gap-2">
                <div class="relative">
                    <button type="button"
                        class="inline-flex h-8 items-center gap-1 rounded-md px-2 text-sm font-medium hover:bg-accent hover:text-accent-foreground"
                        @click="monthMenuOpen = !monthMenuOpen; yearMenuOpen = false">
                        <span x-text="monthNames[month]"></span>
                        <svg class="size-3.5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div x-show="monthMenuOpen" x-cloak x-transition.origin.top
                        class="bg-popover text-popover-foreground absolute top-full left-0 z-20 mt-1 w-44 rounded-md border p-1 shadow-md">
                        <div class="grid grid-cols-3 gap-1">
                            <template x-for="(monthName, monthIndex) in monthNames" :key="monthIndex">
                                <button type="button" class="rounded-sm px-2 py-1 text-xs"
                                    @click="selectMonth(monthIndex)"
                                    :class="month === monthIndex ?
                                        'bg-accent text-accent-foreground' :
                                        'hover:bg-accent hover:text-accent-foreground'">
                                    <span x-text="monthName"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <button type="button"
                        class="inline-flex h-8 items-center gap-1 rounded-md px-2 text-sm font-medium hover:bg-accent hover:text-accent-foreground"
                        @click="yearMenuOpen = !yearMenuOpen; monthMenuOpen = false">
                        <span x-text="year"></span>
                        <svg class="size-3.5 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    <div x-show="yearMenuOpen" x-cloak x-transition.origin.top
                        class="bg-popover text-popover-foreground absolute top-full left-0 z-20 mt-1 h-44 w-24 overflow-y-auto rounded-md border p-1 shadow-md">
                        <template x-for="yearOption in yearOptions()" :key="yearOption">
                            <button type="button" class="block w-full rounded-sm px-2 py-1 text-xs text-left"
                                @click="selectYear(yearOption)"
                                :class="year === yearOption ?
                                    'bg-accent text-accent-foreground' :
                                    'hover:bg-accent hover:text-accent-foreground'">
                                <span x-text="yearOption"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <button type="button"
                class="inline-flex size-8 items-center justify-center rounded-md hover:bg-accent hover:text-accent-foreground"
                @click="nextMonth()">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" />
                </svg>
            </button>
        </div>

        <div class="mb-1 grid grid-cols-7 gap-1">
            <template x-for="weekday in weekdays" :key="weekday">
                <div class="py-1 text-center text-xs font-medium text-muted-foreground" x-text="weekday"></div>
            </template>
        </div>

        <div class="grid grid-cols-7 gap-1">
            <template x-for="dayObject in days" :key="`${dayObject.year}-${dayObject.month}-${dayObject.day}`">
                <button type="button"
                    class="inline-flex size-9 items-center justify-center rounded-md text-sm transition-colors"
                    @click="selectDay(dayObject)"
                    :class="{
                        'text-muted-foreground/50': dayObject.outside && !isSelected(dayObject),
                        'hover:bg-accent hover:text-accent-foreground': !isSelected(dayObject),
                        'bg-primary text-primary-foreground hover:bg-primary': isSelected(dayObject),
                        'border border-border': isToday(dayObject) && !isSelected(dayObject),
                    }">
                    <span x-text="dayObject.day"></span>
                </button>
            </template>
        </div>

        <div x-show="mode === 'datetime-local'" x-cloak class="mt-3 border-t pt-3">
            <label class="mb-1 block text-xs font-medium text-muted-foreground">{{ __('Time') }}</label>
            <input type="time" x-model="selectedTime"
                class="border-input bg-background focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 aria-invalid:border-destructive h-9 w-full rounded-md border px-3 py-1 text-sm shadow-xs outline-none focus-visible:ring-[3px]">
        </div>

        <div class="mt-3 flex items-center justify-between">
            <button type="button" class="text-xs text-muted-foreground hover:text-foreground" @click="clear()">
                {{ __('ui.clear') }}
            </button>
            <button type="button"
                class="inline-flex h-8 items-center justify-center rounded-md border border-input px-3 text-xs font-medium transition-colors hover:bg-accent hover:text-accent-foreground"
                @click="open = false">
                {{ __('ui.done') }}
            </button>
        </div>
    </div>
</div>
