@props([
    'paginator' => null,
])

@if ($paginator)
    <div class="w-full">
        {{ $paginator->links() }}
    </div>
@else
    <nav role="navigation" aria-label="pagination"
        {{ $attributes->merge(['class' => 'mx-auto flex w-full justify-center']) }}>
        {{ $slot }}
    </nav>
@endif
