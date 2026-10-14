<x-guest-layout>
    <div
        class="login-shell"
        x-data="{
            showPassword: false,
            activeSlide: 0,
            paused: false,
            slides: [
                {
                    image: '{{ asset('images/auth/school-binan-front.jpg') }}',
                    alt: 'The front view of a school with rizal statue in the foreground',
                    caption: 'A clear path for every application'
                },
                {
                    image: '{{ asset('images/auth/students-court-left.jpg') }}',
                    alt: 'The left side of a school court with students sitting on the benches and a school building in the background',
                    caption: 'Keep your school community moving forward'
                },
                {
                    image: '{{ asset('images/auth/students-court-center.jpg') }}',
                    alt: 'The center of a school court with students sitting on the benches and a school building in the background',
                    caption: 'Make every admission decision count'
                }
            ],
            startSlideshow() {
                window.setInterval(() => {
                    if (!this.paused) {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                    }
                }, 5200);
            }
        }"
        x-init="startSlideshow()"
    >
        <section class="login-card" aria-label="Administrator portal sign in">
            <div class="login-showcase">
                <div class="showcase-noise" aria-hidden="true"></div>
                <div class="showcase-orbit showcase-orbit--one" aria-hidden="true"></div>
                <div class="showcase-orbit showcase-orbit--two" aria-hidden="true"></div>

                <div class="showcase-content">
                    <div class="showcase-kicker">
                        <span class="kicker-dot" aria-hidden="true"></span>
                        Administration portal - 2026
                    </div>

                    <h1>Lead with<br><em>clarity.</em></h1>
                    <p class="showcase-intro">
                        Sign in to manage registration sessions, review applicants, and keep
                        every admission moving forward.
                    </p>

                    <div
                        class="school-image-frame"
                        aria-label="School administration highlights"
                        @mouseenter="paused = true"
                        @mouseleave="paused = false"
                        @focusin="paused = true"
                        @focusout="paused = false"
                    >
                        {{-- Replace these placeholder illustrations with school images when ready. --}}
                        <div class="school-slideshow" role="region" aria-roledescription="carousel" aria-label="School highlights">
                            <template x-for="(slide, index) in slides" :key="slide.image">
                                <figure
                                    class="school-slide"
                                    :class="{ 'school-slide--active': activeSlide === index }"
                                    x-show="activeSlide === index"
                                    x-cloak
                                    x-transition:enter="school-slide-transition"
                                    x-transition:enter-start="school-slide-enter-start"
                                    x-transition:enter-end="school-slide-enter-end"
                                    x-transition:leave="school-slide-transition"
                                    x-transition:leave-start="school-slide-leave-start"
                                    x-transition:leave-end="school-slide-leave-end"
                                >
                                    <img :src="slide.image" :alt="slide.alt" class="school-image">
                                    <figcaption class="image-frame-caption">
                                        <span class="caption-line" aria-hidden="true"></span>
                                        <span x-text="slide.caption"></span>
                                    </figcaption>
                                </figure>
                            </template>
                        </div>

                        <div class="school-slideshow-controls">
                            <button
                                type="button"
                                class="slideshow-arrow"
                                @click="activeSlide = (activeSlide + slides.length - 1) % slides.length"
                                aria-label="Show previous school highlight"
                            >
                                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                            </button>

                            <div class="slideshow-dots" role="tablist" aria-label="Choose school highlight">
                                <template x-for="(slide, index) in slides" :key="`dot-${index}`">
                                    <button
                                        type="button"
                                        class="slideshow-dot"
                                        :class="{ 'slideshow-dot--active': activeSlide === index }"
                                        @click="activeSlide = index"
                                        :aria-label="`Show school highlight ${index + 1}`"
                                        :aria-selected="activeSlide === index"
                                        role="tab"
                                    ></button>
                                </template>
                            </div>

                            <button
                                type="button"
                                class="slideshow-arrow"
                                @click="activeSlide = (activeSlide + 1) % slides.length"
                                aria-label="Show next school highlight"
                            >
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    <div class="showcase-meta">
                        <div>
                            <span class="meta-value">01</span>
                            <span class="meta-label">Admission<br>oversight</span>
                        </div>
                        <div class="meta-rule" aria-hidden="true"></div>
                        <div>
                            <span class="meta-value">&#8734;</span>
                            <span class="meta-label">Better decisions<br>ahead</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="login-form-panel">
                <div class="login-form-inner">
                    <a href="{{ url('/') }}" class="school-brand" aria-label="{{ config('app.school_name', config('app.name', 'School Portal')) }} home">
                        <span class="school-brand-mark" aria-hidden="true">
                            <i class="fa-solid fa-school" aria-hidden="true"></i>
                        </span>
                        <span class="school-brand-copy">
                            <strong>{{ config('app.school_name', config('app.name', 'School Portal')) }}</strong>
                            <small>Administrator portal</small>
                        </span>
                    </a>

                    <div class="form-heading">
                        <p class="form-eyebrow">Authorized access</p>
                        <h2>Welcome back,<br>administrator.</h2>
                        <p>Sign in to manage sessions, review applicants, and keep your school's admissions on track.</p>
                    </div>

                    @if (session('status'))
                        <div class="status-message" role="status">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="error-summary" role="alert">
                            <span class="error-summary-icon" aria-hidden="true">!</span>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf

                        <div class="form-field">
                            <label for="email">Administrator email</label>
                            <div class="input-shell @error('email') input-shell--error @enderror">
                                <i class="input-icon fa-solid fa-envelope" aria-hidden="true"></i>
                                <input
                                    id="email"
                                    class="portal-input"
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
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <div class="field-label-row">
                                <label for="password">Password</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="subtle-link">Forgot password?</a>
                                @endif
                            </div>
                            <div class="input-shell @error('password') input-shell--error @enderror">
                                <i class="input-icon fa-solid fa-lock" aria-hidden="true"></i>
                                <input
                                    id="password"
                                    class="portal-input portal-input--password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="Enter your password"
                                    required
                                    autocomplete="current-password"
                                >
                                <button
                                    type="button"
                                    class="password-toggle"
                                    @click="showPassword = !showPassword"
                                    x-bind:aria-label="showPassword ? 'Hide password' : 'Show password'"
                                >
                                    <i x-show="!showPassword" class="fa-solid fa-eye" aria-hidden="true"></i>
                                    <i x-show="showPassword" x-cloak class="fa-solid fa-eye-slash" aria-hidden="true"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-options">
                            <label class="remember-option" for="remember_me">
                                <input id="remember_me" type="checkbox" name="remember">
                                <span class="custom-checkbox" aria-hidden="true"></span>
                                <span>Keep me signed in</span>
                            </label>
                        </div>

                        <button type="submit" class="portal-submit">
                            <span>Sign in as administrator</span>
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </button>
                    </form>

                    <div class="secure-note">
                        <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                        <span>Protected access for authorized school staff.</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
