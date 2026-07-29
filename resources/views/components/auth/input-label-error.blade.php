@props([
    'for',
    'value',
    'bag' => null,
])

@php
    $messages = $bag
        ? $errors->{$bag}->get($for)
        : $errors->get($for);
@endphp

<div class="flex items-center justify-between mb-1">
    <x-auth.input-label :for="$for" :value="$value" />

    @if(count($messages))
        <div
            x-data="{ open: false }"
            class="relative">

            <button
                type="button"
                @click="open = !open"
                class="text-red-500 hover:text-red-600"
                title="View validation errors">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14.14A2 2 0 003.82 21h16.36a2 2 0 001.71-3l-8.18-14.14a2 2 0 00-3.42 0z"/>
                </svg>
            </button>

            <div
                x-show="open"
                x-transition
                @click.outside="open = false"
                class="absolute right-0 z-50 mt-1 w-64 rounded-lg border border-red-200 bg-white p-3 shadow-lg">
                <ul class="list-disc pl-5 text-sm text-red-600">
                    @foreach($messages as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>