<div {{ $attributes->merge(['class' => 'py-6 text-center text-sm']) }}>
    {{ $slot ?: 'No results found.' }}
</div>
