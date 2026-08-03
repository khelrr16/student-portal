<div
    @class([
        'fixed inset-0 bg-black/50 flex items-center justify-center' => $showColumnsModal,
        'hidden' => ! $showColumnsModal,
    ])>
    <div class="bg-white dark:bg-gray-900 rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Select visible columns</h3>
            <button type="button" wire:click="$set('showColumnsModal', false)" class="text-gray-500">✕</button>
        </div>

        <div class="grid grid-cols-2 gap-3">
            @foreach ($columns as $column)
                <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                    <input type="checkbox" wire:model="visibleColumns" value="{{ $column['key'] }}" class="rounded border-gray-300">
                    <span>{{ $column['label'] }}</span>
                </label>
            @endforeach
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <button type="button" wire:click="$set('showColumnsModal', false)" class="px-3 py-2 rounded bg-gray-300 dark:bg-gray-700">Cancel</button>
            <button type="button" wire:click="saveColumns" class="px-3 py-2 rounded bg-blue-500 text-white">Save</button>
        </div>
    </div>
</div>