@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full border-l-4 border-teal-700 bg-teal-50 px-3 py-2 text-start text-base font-semibold text-teal-800 transition focus:outline-none'
    : 'block w-full border-l-4 border-transparent px-3 py-2 text-start text-base font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:outline-none';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
