@php $l = app()->getLocale(); @endphp

<x-portal-layout :menuAtas="$menuAtas" :menuBawah="$menuBawah" :pageTitle="$siteTitle" :portalPage="$portalPage">
    @foreach ($blocks as $block)
        @includeIf('portal::blocks.render-' . $block['type'], ['block' => $block, 'l' => $l])
    @endforeach
</x-portal-layout>
