<x-guest-layout>
    <div class="recovery-shell">
        <section class="recovery-card" aria-labelledby="recovery-title">
            <x-auth.recovery-aside :current-step="1" />

            <main class="recovery-panel">
                <a href="{{ route('login') }}" class="recovery-back-link">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    <span>Back to administrator sign in</span>
                </a>

                <div class="recovery-panel-inner">
                    <div class="recovery-icon" aria-hidden="true">
                        <i class="fa-solid fa-lock-open"></i>
                    </div>

                    <p class="recovery-eyebrow">Password recovery</p>
                    <h2 id="recovery-title">Forgot your<br><em>password?</em></h2>
                    <p class="recovery-description">
                        Enter the email connected to your administrator account. We will send a secure link to help you set a new password.
                    </p>

                    <x-auth.session-status class="recovery-status" :status="session('status')" />

                    @if ($errors->any())
                        <div class="recovery-error-summary" role="alert">
                            <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="recovery-form">
                        @csrf

                        <div class="recovery-field">
                            <label for="email">Administrator email</label>
                            <div class="recovery-input-shell @error('email') recovery-input-shell--error @enderror">
                                <i class="fa-solid fa-envelope recovery-input-icon" aria-hidden="true"></i>
                                <input
                                    id="email"
                                    class="recovery-input"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
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

                        <button type="submit" class="recovery-submit">
                            <span>Email me a reset link</span>
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        </button>
                    </form>

                    <div class="recovery-help-note">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        <p>For security, the reset link will only be sent if the email belongs to an administrator account.</p>
                    </div>
                </div>
            </main>
        </section>
    </div>
</x-guest-layout>
