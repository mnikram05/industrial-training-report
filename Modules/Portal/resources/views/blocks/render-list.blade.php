@php $d = $block['data']; $items = $d['items_' . $l] ?? []; @endphp
<section class="py-8">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="group transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
             style="background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 15px; padding: 24px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03)">
            @if (!empty($d['heading_' . $l]))
                <div class="mb-4 flex items-center gap-3">
                    @if (!empty($d['icon']))
                        <div class="flex size-10 items-center justify-center rounded-xl transition-transform duration-300 group-hover:scale-110" style="background-color: rgba(233, 69, 96, 0.1)">
                            <span class="text-xl">{{ $d['icon'] }}</span>
                        </div>
                    @endif
                    <h3 class="text-lg font-bold" style="color: #000000">{{ $d['heading_' . $l] }}</h3>
                </div>
            @endif
            @if (is_array($items) && count($items))
                <ul class="space-y-2">
                    @foreach ($items as $item)
                        <li class="flex items-start gap-2">
                            <span class="mt-2 size-1.5 shrink-0 rounded-full" style="background-color: var(--portal-accent)"></span>
                            <span class="text-sm" style="color: #000000">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
