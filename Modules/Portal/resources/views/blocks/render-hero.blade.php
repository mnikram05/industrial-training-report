@php $d = $block['data']; @endphp
<section class="relative min-h-[250px] overflow-hidden flex items-center justify-center text-center text-white"
         style="background-size: 200% 200%; background-image: linear-gradient(135deg, var(--portal-hero-from), var(--portal-hero-to), var(--portal-accent), var(--portal-hero-from)); animation: heroGradient 3s ease forwards; padding: 40px 20px">
    <div class="absolute -left-32 -top-32 size-96 rounded-full opacity-[0.07] blur-3xl" style="background-color: var(--portal-accent); animation: floatBlob 2s ease-in-out forwards"></div>
    <div class="absolute -bottom-32 -right-32 size-96 rounded-full opacity-[0.07] blur-3xl" style="background-color: var(--portal-accent); animation: floatBlob 2s ease-in-out 0.5s forwards"></div>
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(255,255,255,0.03)_0%,transparent_70%)]"></div>

    <div class="relative mx-auto max-w-4xl">
        @if (!empty($d['institution_' . $l]))
            <p class="animate-fade-in text-xs font-bold uppercase tracking-[0.3em] sm:text-sm" style="color: var(--portal-accent)">
                {{ $d['institution_' . $l] }}
            </p>
        @elseif (!empty($d['subtitle_' . $l]))
            <p class="animate-fade-in text-xs font-bold uppercase tracking-[0.3em] sm:text-sm" style="color: var(--portal-accent)">
                {{ $d['subtitle_' . $l] }}
            </p>
        @endif
        @if (!empty($d['title_' . $l]))
            <h1 class="mt-1 text-3xl font-black uppercase tracking-tight drop-shadow-xl sm:text-4xl lg:text-5xl"
                x-data="{ text: '', fullText: @js($d['title_' . $l]), done: false }"
                x-init="
                    let i = 0;
                    setTimeout(() => {
                        const interval = setInterval(() => {
                            text = fullText.substring(0, i + 1);
                            i++;
                            if (i >= fullText.length) {
                                clearInterval(interval);
                                done = true;
                            }
                        }, 40);
                    }, 300);
                ">
                <span x-text="text"></span><span x-show="!done" class="inline-block w-[3px] animate-pulse" style="height: 0.8em; background-color: var(--portal-accent); vertical-align: middle; margin-left: 2px;"></span>
            </h1>
        @endif
        <div class="mx-auto animate-fade-in" style="width: 80px; height: 4px; background: linear-gradient(90deg, var(--portal-accent), #ff6b6b); margin: 12px auto; border-radius: 2px; animation-delay: 0.2s"></div>
        @if (!empty($d['subtitle2_' . $l]))
            <h2 class="mt-4 animate-fade-in text-base font-bold tracking-wide sm:text-lg" style="animation-delay: 0.3s">
                {{ $d['subtitle2_' . $l] }}
            </h2>
        @endif
        @if (!empty($d['session_' . $l]))
            <p class="mt-2 animate-fade-in text-sm tracking-wide text-gray-400" style="animation-delay: 0.4s">
                {{ $d['session_' . $l] }}
            </p>
        @endif
        @if (!empty($d['address']))
            <p class="mt-4 animate-fade-in flex items-center justify-center gap-2 text-sm tracking-wide text-gray-400" style="animation-delay: 0.3s">
                <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                </svg>
                {{ $d['address'] }}
            </p>
        @endif
    </div>
</section>
