<x-guest-layout>
    <div class="recovery-shell" x-data="{ showPassword: false, showConfirmation: false }">
        <section class="recovery-card" aria-labelledby="recovery-title">
            <x-auth.recovery-aside :current-step="2" />

            <main class="recovery-panel">
                <a href="{{ route('login') }}" class="recovery-back-link">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    <span>Back to administrator sign in</span>
                </a>

                <div class="recovery-panel-inner">
                    <div class="recovery-icon" aria-hidden="true">
                        <i class="fa-solid fa-key"></i>
                    </div>

                    <p class="recovery-eyebrow">Create a new password</p>
                    <h2 id="recovery-title">Make it<br><em>secure.</em></h2>
                    <p class="recovery-description">
                        Choose a strong password for your administrator account, then you can return to managing your school portal.
                    </p>

                    @if ($errors->any())
                        <div class="recovery-error-summary" role="alert">
                            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.store') }}" class="recovery-form">
                        @csrf

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="recovery-field">
                            <label for="email">Administrator email</label>
                            <div class="recovery-input-shell @error('email') recovery-input-shell--error @enderror">
                                <i class="fa-solid fa-envelope recovery-input-icon" aria-hidden="true"></i>
                                <input
                                    id="email"
                                    class="recovery-input"
                                    type="email"
                                    name="email"
                                    value="{{ old('email', $request->email) }}"
                                    placeholder="admin@school.edu"
                                    required
                                    autofocus
                                    autocomplete="username"
                                >
                            </div>
                            @error('email')
                                <p class="recovery-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="recovery-field">
                            <label for="password">New password</label>
                            <div class="recovery-input-shell @error('password') recovery-input-shell--error @enderror">
                                <i class="fa-solid fa-lock recovery-input-icon" aria-hidden="true"></i>
                                <input
                                    id="password"
                                    class="recovery-input recovery-input--password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Enter a new password"
                                    required
                                    autocomplete="new-password"
                                >
                                <button
                                    type="button"
                                    class="recovery-password-toggle"
                                    @click="showPassword = !showPassword"
                                    x-bind:aria-label="showPassword ? 'Hide new password' : 'Show new password'"
                                >
                                    <i x-show="!showPassword" class="fa-solid fa-eye" aria-hidden="true"></i>
                                    <i x-show="showPassword" x-cloak class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="recovery-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="recovery-field">
                            <label for="password_confirmation">Confirm new password</label>
                            <div class="recovery-input-shell @error('password_confirmation') recovery-input-shell--error @enderror">
                                <i class="fa-solid fa-shield-halved recovery-input-icon" aria-hidden="true"></i>
                                <input
                                    id="password_confirmation"
                                    class="recovery-input recovery-input--password"
                                    x-bind:type="showConfirmation ? 'text' : 'password'"
                                    name="password_confirmation"
                                    placeholder="Repeat your new password"
                                    required
                                    autocomplete="new-password"
                                >
                                <button
                                    type="button"
                                    class="recovery-password-toggle"
                                    @click="showConfirmation = !showConfirmation"
                                    x-bind:aria-label="showConfirmation ? 'Hide password confirmation' : 'Show password confirmation'"
                                >
                                    <i x-show="!showConfirmation" class="fa-solid fa-eye" aria-hidden="true"></i>
                                    <i x-show="showConfirmation" x-cloak class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="recovery-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="recovery-password-tip">
                            <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                            <span>Use at least 8 characters and avoid reusing a password from another account.</span>
                        </div>

                        <button type="submit" class="recovery-submit">
                            <span>Update administrator password</span>
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </main>
        </section>
    </div>
</x-guest-layout>
