<div wire:init="loadChart" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h3 class="text-2xl font-semibold tracking-tight">Respondents Overview</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Distribution of respondents by SHS strand.</p>
            </div>

            <div class="text-sm text-gray-500 dark:text-gray-400">
                Total respondents: <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalRespondents }}</span>
            </div>
        </div>

        @if ($loading)
            @include('livewire.dashboard.partials.loading')
        @elseif ($errorMessage)
            @include('livewire.dashboard.partials.error')
        @else
            @include('livewire.dashboard.partials.chart')
        @endif
    </div>
</div>