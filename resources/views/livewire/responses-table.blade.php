<div wire:init="loadResponses" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex-1">
                <input
                    type="text"
                    wire:model.live.debounce.500ms="search"
                    placeholder="Search users..."
                    class="border rounded px-3 py-2 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            </div>

            <div class="flex gap-2">
                <button
                    type="button"
                    wire:click="$set('showColumnsModal', true)"
                    class="bg-gray-600 text-white px-3 py-2 rounded">
                    Select Columns
                </button>
            </div>
        </div>

        @if ($isLoading)
            @include('livewire.responses.partials.loading')
        @else
            @if ($errorMessage)
                <div class="rounded border border-red-300 bg-red-50 text-red-700 px-4 py-3">
                    {{ $errorMessage }}
                </div>
            @endif

            @include('livewire.responses.partials.table')
        @endif

        @include('livewire.responses.partials.column-modal')
        @include('livewire.responses.partials.details-modal')
    </div>
</div>