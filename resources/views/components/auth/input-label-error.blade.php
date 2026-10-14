@props(['for', 'value', 'bag' => null])

@php
    $messages = $bag ? $errors->{$bag}->get($for) : $errors->get($for);
@endphp

<div class="flex items-center justify-between">
    <x-auth.input-label :for="$for" :value="$value" />
    @if (count($messages))
        <span class="text-rose-600" title="{{ implode(' ', $messages) }}"><i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i></span>
    @endif
</div>
