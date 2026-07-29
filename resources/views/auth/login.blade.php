<x-guest-layout>
    <div
        x-data="{ 
            register: {{ $errors->register->any() ? 'true' : 'false' }}
        }"
        :class="{ 'active': register }">

        <!-- Image 1 -->
        <div
            style="background-image: url('/images/auth/image2.webp');"
            class="absolute left-[10%] w-full h-full bg-cover">
        </div>

        <!-- Image 2 -->
        <div
            style="background-image: url('/images/auth/image1.png');"
            class="absolute w-full h-full bg-cover bg-right wipe-effect">
        </div>

        <!-- White Wipe -->
        <div
            class="form-container p-10 w-2/5 absolute overflow-hidden bg-white dark:bg-gray-900 dark:text-gray-300">

            <div class="h-3/4 w-100">
                <!-- LOGIN FORM -->
                <div 
                    x-show="!register"
                    x-transition:enter="transition transform duration-500"
                    x-transition:enter-start="-translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition transform duration-500"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="-translate-x-full opacity-0"

                    class="login-form absolute inset-0 w-full">
                    <div class="m-5">
                        <div class="h-1/4 flex items-center justify-center my-10">
                            <span class="text-4xl font-semibold">Login</span>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div>
                                <!-- Email Address -->
                                <div>
                                    <x-auth.input-label-error for="email" value="Email" bag="login" />
                                    <x-auth.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                </div>

                                <!-- Password -->
                                <div class="mt-4">
                                    <x-auth.input-label-error for="password" value="Password" bag="login" />
                                    <x-auth.text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                                </div>

                                <div class="mt-4 flex items-center justify-between gap-5">
                                    <!-- Remember Me -->
                                    <label for="remember_me" class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                        <input
                                            id="remember_me"
                                            type="checkbox"
                                            name="remember"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">

                                        <span class="ml-2">Remember me</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a
                                            href="{{ route('password.request') }}"
                                            class="text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-gray-400 dark:hover:text-gray-100">
                                            Forgot password
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col items-center justify-center mt-4 gap-4">
                                <x-auth.primary-button class="ms-3">
                                    Log in
                                </x-auth.primary-button>
                            </div>
                        </form>

                        <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                            Don't have account? <button @click="register = true" class="text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-gray-400 dark:hover:text-gray-100">Register</a>
                        </div>
                    </div>
                </div>

                <!-- REGISTER FORM -->
                <div 
                    x-show="register"
                    x-transition:enter="transition transform duration-500"
                    x-transition:enter-start="translate-x-full opacity-0"
                    x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition transform duration-500"
                    x-transition:leave-start="translate-x-0 opacity-100"
                    x-transition:leave-end="translate-x-full opacity-0"

                    class="register-form absolute inset-0 w-full">
                    <div class="m-5">
                        <div class="h-1/4 flex items-center justify-center mt-10 mb-3">
                            <span class="text-4xl font-semibold">Register</span>    
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-auth.input-label-error for="name" value="Name" bag="register" />
                                <x-auth.text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            </div>

                            <!-- Email Address -->
                            <div class="mt-4">
                                <x-auth.input-label-error for="email" value="Email" bag="register" />
                                <x-auth.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                                <x-auth.input-error :messages="$errors->register->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-auth.input-label-error for="password" value="Password" bag="register" />

                                <x-auth.text-input id="password" class="block mt-1 w-full"
                                                type="password"
                                                name="password"
                                                required autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4">
                                <x-auth.input-label-error for="password_confirmation" value="Confirm Password" bag="register" />
                                <x-auth.text-input id="password_confirmation" class="block mt-1 w-full"
                                                type="password"
                                                name="password_confirmation" required autocomplete="new-password" />
                            </div>

                            <div class="flex flex-col items-center justify-center mt-4 gap-4">
                                <x-auth.primary-button class="ms-3">
                                    Register
                                </x-auth.primary-button>
                            </div>
                        </form>
                        
                        <div class="mt-4 text-center text-sm text-gray-600 dark:text-gray-400">
                            Already have account? <button @click="register = false" class="text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-gray-400 dark:hover:text-gray-100">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>