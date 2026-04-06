{{-- Rough match: inner pages (text, weekly grid, tables) without tall marketing hero --}}
<div class="py-8 sm:py-10">
    <x-portal.skeleton-bone class="mb-2 h-8 w-2/3 max-w-lg" />
    <x-portal.skeleton-bone class="mb-8 h-4 w-40" />

    <div class="mb-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
        @for ($i = 0; $i < 8; $i++)
            <x-portal.skeleton-bone class="h-16 sm:h-20" />
        @endfor
    </div>

    <x-portal.skeleton-bone class="mb-6 h-56 w-full sm:h-64" />

    <div class="space-y-4">
        <x-portal.skeleton-bone class="h-4 w-full" />
        <x-portal.skeleton-bone class="h-4 w-11/12" />
        <x-portal.skeleton-bone class="h-4 w-full" />
        <x-portal.skeleton-bone class="h-4 w-4/5" />
    </div>

    <div class="mt-8 space-y-5">
        <x-portal.skeleton-bone class="h-36 w-full" />
        <x-portal.skeleton-bone class="h-36 w-full" />
    </div>
</div>
