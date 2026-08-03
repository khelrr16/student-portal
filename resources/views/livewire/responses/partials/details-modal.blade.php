<div
    @class([
        'fixed inset-0 bg-black/50 flex items-center justify-center' => $showDetailsModal,
        'hidden' => ! $showDetailsModal,
    ])>
    <div class="bg-gray-100 dark:bg-gray-900 rounded-lg w-3/4 max-h-[80vh] overflow-y-auto p-6">
        <div class="flex justify-between mb-4 border-b border-gray-300 dark:border-gray-700 pb-2">
            <h2 class="text-xl font-bold">Response Details</h2>

            <button type="button" wire:click="closeDetails">✕</button>
        </div>

        <div class="flex">
            <div class="w-1/4 p-4">
                <img
                    src="{{ $selectedResponse['Profile Picture'] ?? asset('images/response/default.jpg') }}"
                    alt="Profile Picture"
                    class="w-40 h-40 object-cover rounded-lg">
            </div>

            <div class="w-3/4 p-4 grid grid-cols-2 gap-3">
                <x-response.field label="First Name" :value="$selectedResponse['First Name'] ?? 'N/A'" />
                <x-response.field label="Middle Name" :value="$selectedResponse['Middle Name'] ?? 'N/A'" />
                <x-response.field label="Last Name" :value="$selectedResponse['Last Name'] ?? 'N/A'" />
                <x-response.field label="Extension Name" :value="$selectedResponse['Extension Name'] ?? 'N/A'" />
                <x-response.field label="Email" :value="$selectedResponse['Email Address'] ?? 'N/A'" />
                <x-response.field label="SHS Strand" :value="$selectedResponse['SHS Strand'] ?? 'N/A'" />
                <x-response.field label="Birthdate" :value="$selectedResponse['Birthdate'] ?? 'N/A'" />
                <x-response.field label="Complete Address" :value="$selectedResponse['Complete Address'] ?? 'N/A'" />
                <x-response.field label="LRN" :value="$selectedResponse['LRN'] ?? 'N/A'" />
                <x-response.field label="Place of Birth" :value="$selectedResponse['Place of Birth'] ?? 'N/A'" />
                <x-response.field label="Nationality" :value="$selectedResponse['Nationality'] ?? 'N/A'" />
                <x-response.field label="Sex" :value="$selectedResponse['Sex'] ?? 'N/A'" />
                <x-response.field label="Civil Status" :value="$selectedResponse['Civil Status'] ?? 'N/A'" />
                <x-response.field label="Religion" :value="$selectedResponse['Religion'] ?? 'N/A'" />
                <x-response.field label="Highest Educational Attainment" :value="$selectedResponse['Highest Educational Attained'] ?? 'N/A'" />
                <x-response.field label="Last School Attended" :value="$selectedResponse['Last School Attended'] ?? 'N/A'" />
                <x-response.field label="Last School Year Attended" :value="$selectedResponse['Last School Year Attended'] ?? 'N/A'" />
                <x-response.field label="SHS Grade Level" :value="$selectedResponse['SHS Grade Level'] ?? 'N/A'" />
            </div>
        </div>
    </div>
</div>