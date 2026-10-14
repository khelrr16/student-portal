@props(['currentStep' => 1])

<aside class="recovery-aside" aria-label="Password recovery steps">
    <div class="recovery-aside-glow recovery-aside-glow--one" aria-hidden="true"></div>
    <div class="recovery-aside-glow recovery-aside-glow--two" aria-hidden="true"></div>

    <a href="{{ url('/') }}" class="recovery-brand" aria-label="{{ config('app.school_name', config('app.name', 'School Portal')) }} home">
        <span class="recovery-brand-mark" aria-hidden="true">
            @if (config('app.school_logo'))
                <img src="{{ asset(config('app.school_logo')) }}" alt="">
            @else
                <i class="fa-solid fa-school"></i>
            @endif
        </span>
        <span class="recovery-brand-copy">
            <strong>{{ config('app.school_name', config('app.name', 'School Portal')) }}</strong>
            <small>Administrator portal</small>
        </span>
    </a>

    <div class="recovery-aside-content">
        <p class="recovery-kicker">
            <span class="kicker-dot" aria-hidden="true"></span>
            Secure account recovery
        </p>
        <h1>Back to<br><em>your work.</em></h1>
        <p class="recovery-aside-intro">
            Regain access to the tools that keep your school's registration and admissions organized.
        </p>

        <div class="recovery-steps">
            <div class="recovery-step {{ $currentStep === 1 ? 'recovery-step--active' : 'recovery-step--complete' }}">
                <span class="recovery-step-number">
                    <i class="fa-solid {{ $currentStep > 1 ? 'fa-check' : 'fa-envelope' }}" aria-hidden="true"></i>
                </span>
                <span>
                    <strong>Verify your email</strong>
                    <small>Confirm the administrator account</small>
                </span>
            </div>
            <div class="recovery-step-line" aria-hidden="true"></div>
            <div class="recovery-step {{ $currentStep === 2 ? 'recovery-step--active' : ($currentStep > 2 ? 'recovery-step--complete' : '') }}">
                <span class="recovery-step-number">
                    <i class="fa-solid fa-key" aria-hidden="true"></i>
                </span>
                <span>
                    <strong>Choose a new password</strong>
                    <small>Create a secure replacement</small>
                </span>
            </div>
            <div class="recovery-step-line" aria-hidden="true"></div>
            <div class="recovery-step {{ $currentStep === 3 ? 'recovery-step--active' : '' }}">
                <span class="recovery-step-number">
                    <i class="fa-solid fa-arrow-right-to-bracket" aria-hidden="true"></i>
                </span>
                <span>
                    <strong>Return to your portal</strong>
                    <small>Continue managing admissions</small>
                </span>
            </div>
        </div>
    </div>

    <div class="recovery-aside-footer">
        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
        <span>Private, protected, and only for authorized school staff.</span>
    </div>
</aside>
