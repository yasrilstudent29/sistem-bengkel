@props(['active' => false])

@php
$classes = $active
    ? 'flex items-center gap-2 px-3 py-1.5 rounded-lg text-white text-[15px] font-semibold transition w-full'
    : 'flex items-center gap-2 px-3 py-1.5 rounded-lg text-white text-[15px] font-medium hover:bg-white/10 transition w-full';

$bgStyle = $active ? 'background-color: rgba(250, 124, 32, 0.25); border-left: 3px solid #fa7c20;' : '';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} style="{{ $bgStyle }}">
    @isset($icon)
        {{ $icon }}
    @endisset
    <span class="sidebar-label">{{ $slot }}</span>
</a>