@props(['column', 'label'])
@php
    $current = request()->query('sort', 'name');
    $dir = request()->query('dir', 'asc');
    $newDir = ($current === $column && $dir === 'asc') ? 'desc' : 'asc';
    $arrow = $current === $column ? ($dir === 'asc' ? ' ▲' : ' ▼') : '';
@endphp
<a href="{{ route('products.index', array_merge(request()->query(), ['sort' => $column, 'dir' => $newDir, 'page' => 1])) }}">{{ $label }}{{ $arrow }}</a>
