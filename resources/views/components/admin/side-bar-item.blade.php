@php
    $currentRoute = explode(".", Route::currentRouteName())[0];
    $routeName = explode(".", $uri)[0];
    $isActive = ($currentRoute === $routeName);
    $state = $isActive ? '' : 'collapsed';
@endphp

<li class="nav-item">
    <a class="nav-link {{ $state }}" href="{{ route($uri) }}">
        <i class="{{ $icon }}"></i>
        <span>{{ $item }}</span>
    </a>
</li>