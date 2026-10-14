@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div x-data="{ show: @js($show) }" x-init="$watch('show', value => document.body.classList.toggle('overflow-y-hidden', value))" x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null" x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null" x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show" class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0" style="display: {{ $show ? 'block' : 'none' }};">
    <div x-show="show" class="fixed inset-0 bg-slate-900/40" x-on:click="show = false" x-transition.opacity></div>
    <div x-show="show" class="relative mx-auto mb-6 w-full overflow-hidden rounded-2xl bg-white shadow-xl {{ $maxWidth }}" x-transition>
        {{ $slot }}
    </div>
</div>
