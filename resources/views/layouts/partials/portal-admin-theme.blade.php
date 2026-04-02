@php
    $lightGroups = \App\Support\PortalTheme::lightPropertyGroups();
    $darkGroups = \App\Support\PortalTheme::darkPropertyGroups();
    $lightVars = array_merge($lightGroups['portal'], $lightGroups['tailwind']);
    $darkVars = array_merge($darkGroups['portal'], $darkGroups['tailwind']);
@endphp
<style>
    :root {
        @foreach ($lightVars as $name => $value)
            --{{ $name }}: {{ $value }};
        @endforeach
    }

    html.dark {
        @foreach ($darkVars as $name => $value)
            --{{ $name }}: {{ $value }};
        @endforeach
    }
</style>
