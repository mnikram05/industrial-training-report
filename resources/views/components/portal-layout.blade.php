@props([
    'menuAtas' => collect(),
    'menuBawah' => collect(),
    'pageTitle' => null,
    'portalPage' => null,
    /** @var 'landing'|'content'|null Auto when null: home → landing, else content */
    'skeletonVariant' => null,
])

@include('portal::layout', [
    'menuAtas' => $menuAtas,
    'menuBawah' => $menuBawah,
    'pageTitle' => $pageTitle,
    'portalPage' => $portalPage,
    'skeletonVariant' => $skeletonVariant,
    'slot' => $slot,
])
