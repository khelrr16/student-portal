<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Complete Profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Complete your profile information and email address to proceed.") }}
        </p>
    </header>

    <form method="post" class="mt-6 space-y-6">
        @csrf
        @method('POST')

        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Birthday')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="strand" :value="__('Strand')" />

            <select
                id="strand"
                name="strand"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
            >
                <option value="">-- Select Strand --</option>

                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('strand') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->subject_name }}
                    </option>
                @endforeach
            </select>

            <x-input-error class="mt-2" :messages="$errors->get('strand')" />
        </div>

        <div>
            <x-input-label for="year" :value="__('Year')" />

            <select
                id="year"
                name="year"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
            >
                <option value="">-- Select Year --</option>

                <option value="grade11" {{ old('year') == 'grade11' ? 'selected' : '' }}>
                    Grade 11
                </option>
                <option value="grade12" {{ old('year') == 'grade12' ? 'selected' : '' }}>
                    Grade 12
                </option>
            </select>

            <x-input-error class="mt-2" :messages="$errors->get('year')" />
        </div>
        
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
