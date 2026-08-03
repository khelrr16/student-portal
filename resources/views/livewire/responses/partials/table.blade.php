<div class="overflow-x-auto">
    <table class="table-auto w-full border-spacing-x-5">
        <thead>
            <tr>
                @if ($this->showColumn('dateEntered'))
                    <th wire:click="sort('dateEntered')" class="cursor-pointer text-left">Date Entered</th>
                @endif

                @if ($this->showColumn('fullName'))
                    <th wire:click="sort('fullName')" class="cursor-pointer text-left">Full Name</th>
                @endif

                @if ($this->showColumn('email'))
                    <th wire:click="sort('email')" class="cursor-pointer text-left">Email</th>
                @endif

                @if ($this->showColumn('shsStrand'))
                    <th wire:click="sort('shsStrand')" class="cursor-pointer text-left">SHS Strand</th>
                @endif

                @if ($this->showColumn('birthdate'))
                    <th wire:click="sort('birthdate')" class="cursor-pointer text-left">Birthdate</th>
                @endif

                @if ($this->showColumn('address'))
                    <th wire:click="sort('address')" class="cursor-pointer text-left">Complete Address</th>
                @endif

                @if ($this->showColumn('lrn'))
                    <th wire:click="sort('lrn')" class="cursor-pointer text-left">LRN</th>
                @endif

                @if ($this->showColumn('sex'))
                    <th wire:click="sort('sex')" class="cursor-pointer text-left">Sex</th>
                @endif

                @if ($this->showColumn('civilStatus'))
                    <th wire:click="sort('civilStatus')" class="cursor-pointer text-left">Civil Status</th>
                @endif

                <th class="text-left">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($this->filteredResponses as $index => $response)
                <tr wire:key="response-{{ $index }}-{{ $response['Email Address'] ?? $response['Timestamp'] ?? 'row' }}">
                    @if ($this->showColumn('dateEntered'))
                        <td>{{ $this->formatDate($response['Timestamp'] ?? null) }}</td>
                    @endif

                    @if ($this->showColumn('fullName'))
                        <td>{{ $this->fullName($response) ?: 'N/A' }}</td>
                    @endif

                    @if ($this->showColumn('email'))
                        <td>{{ $response['Email Address'] ?? 'N/A' }}</td>
                    @endif

                    @if ($this->showColumn('shsStrand'))
                        <td>{{ filled($response['SHS Strand'] ?? null) ? $response['SHS Strand'] : 'N/A' }}</td>
                    @endif

                    @if ($this->showColumn('birthdate'))
                        <td>{{ filled($response['Birthdate'] ?? null) ? $response['Birthdate'] : 'N/A' }}</td>
                    @endif

                    @if ($this->showColumn('address'))
                        <td>{{ $response['Complete Address'] ?? 'N/A' }}</td>
                    @endif

                    @if ($this->showColumn('lrn'))
                        <td>{{ $response['LRN'] ?? 'N/A' }}</td>
                    @endif

                    @if ($this->showColumn('sex'))
                        <td>{{ $response['Sex'] ?? 'N/A' }}</td>
                    @endif

                    @if ($this->showColumn('civilStatus'))
                        <td>{{ $response['Civil Status'] ?? 'N/A' }}</td>
                    @endif

                    <td>
                        <button
                            type="button"
                            wire:click="openDetails({{ $index }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded">
                            View
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="py-6 text-center text-gray-500">No responses found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>