@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800']) }} role="status">
        <i class="fa-solid fa-circle-check mr-2" aria-hidden="true"></i>{{ $status }}
    </div>
@endif
