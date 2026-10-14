@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-2 block text-xs font-bold uppercase tracking-wider text-slate-600']) }}>
    {{ $value ?? $slot }}
</label>
