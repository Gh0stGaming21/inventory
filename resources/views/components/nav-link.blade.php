@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-5 py-2.5 text-base font-medium text-white bg-gradient-to-r from-sky-600 to-sky-800 rounded-md shadow-md transition-all duration-150 ease-in-out'
            : 'inline-flex items-center px-5 py-2.5 text-base font-medium text-white hover:bg-sky-800 hover:shadow-md rounded-md shadow-sm transition-all duration-150 ease-in-out';
@endphp

@if($active ?? false)
<a {{ $attributes->merge(['class' => $classes . ' active-nav-link']) }}>
    {{ $slot }}
</a>
@else
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
@endif
