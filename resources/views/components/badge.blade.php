@props(['stock'])
@php
    if ($stock <= 0) {
        $label = 'Habis';
        $class = 'badge-red';
    } elseif ($stock < config('pos.low_stock_threshold')) {
        $label = 'Menipis';
        $class = 'badge-yellow';
    } else {
        $label = 'Aman';
        $class = 'badge-green';
    }
@endphp
<span {{ $attributes->merge(['class' => "badge $class"]) }}>{{ $label }}</span>