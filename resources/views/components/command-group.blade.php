<div
    {{ $attributes->merge(['class' => 'overflow-hidden p-1 text-foreground [&_[data-slot=command-group-heading]]:text-muted-foreground [&_[data-slot=command-group-heading]]:px-2 [&_[data-slot=command-group-heading]]:py-1.5 [&_[data-slot=command-group-heading]]:text-xs [&_[data-slot=command-group-heading]]:font-medium']) }}>
    {{ $slot }}
</div>
