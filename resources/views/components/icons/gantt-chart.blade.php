@props([
    'variant' => 'outline',
])

@php
    $strokeWidth = match ($variant) {
        'outline' => 1.5,
        'mini' => 2.25,
        'micro' => 2.5,
    };
@endphp

<svg xmlns="http://www.w3.org/2000/svg"
     width="24"
     height="24"
     viewBox="0 0 24 24"
     fill="none"
     stroke="currentColor"
     stroke-width="{{ $strokeWidth }}"
     stroke-linecap="round"
     linejoin="round"
     class="lucide lucide-square-chart-gantt">
    <rect width="18" height="18" x="3" y="3" rx="2"/>
    <path d="M9 8h7"/>
    <path d="M8 12h6"/>
    <path d="M11 16h5"/>
</svg>
