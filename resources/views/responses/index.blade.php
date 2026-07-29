<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Responses
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="GET" action="{{ route('responses.index') }}" class="mb-3">
                        <div class="flex gap-2">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search users..."
                                class="border rounded px-3 py-2 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">

                            <button
                                type="submit"
                                class="bg-blue-500 text-white px-4 rounded">
                                Search
                            </button>
                        </div>
                    </form>

                    <div x-data='{
                        open: false, 
                        selected: null, 
                        responses: @json($responses)
                        
                    }'>
                        <table class="table-auto w-full">
                            <thead>
                                <tr>
                                    <th>Date Entered</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Birthday</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                            @foreach($responses as $response)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($response['Timestamp'])->format('Y-m-d') }}</td>
                                    <td>{{ $response['First Name'] }} {{ $response['Middle Name'] }} {{ $response['Last Name'] }} {{ $response['Extension Name'] }}</td>
                                    <td>{{ $response['Email'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($response['Birthday'])->format('m-d-Y') }}</td>
                                    <td>
                                        <button
                                            @click='selected = @json($response); open = true;'
                                            class="bg-blue-500 text-white px-3 py-1 rounded">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div
                            x-show="open"
                            x-cloak
                            class="fixed inset-0 bg-black/50 flex items-center justify-center">

                            <div class="bg-gray-100 dark:bg-gray-900 rounded-lg w-3/4 max-h-[80vh] overflow-y-auto p-6">
                                <div class="flex justify-between mb-4">
                                    <h2 class="text-xl font-bold">
                                        Response Details
                                    </h2>

                                    <button @click="open = false">
                                        ✕
                                    </button>
                                </div>

                                <template
                                    x-for="(answer, question) in selected"
                                    :key="question">

                                    <div class="mb-4">
                                        <h4 class="font-semibold" x-text="question">
                                        </h4>

                                        <p x-text="answer"></p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
