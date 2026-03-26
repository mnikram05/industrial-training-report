@props(['menuAtas' => collect(), 'menuBawah' => collect(), 'pageTitle' => null, 'portalPage' => null])

@include('portal::layout', ['menuAtas' => $menuAtas, 'menuBawah' => $menuBawah, 'pageTitle' => $pageTitle, 'portalPage' => $portalPage, 'slot' => $slot])
