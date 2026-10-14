<div class="min-h-screen bg-slate-50">
    <div class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8 lg:py-12">
        <div class="mb-8 flex items-start gap-4">
            <div class="grid h-16 w-16 shrink-0 place-items-center overflow-hidden rounded-2xl bg-teal-700 text-xl text-white shadow-sm ring-4 ring-teal-50">
                @if (config('app.school_logo'))
                    <img src="{{ asset(config('app.school_logo')) }}" alt="{{ config('app.school_name') }} logo" class="h-full w-full object-contain bg-white p-2">
                @else
                    <i class="fa-solid fa-school" aria-hidden="true"></i>
                @endif
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">{{ config('app.school_name') }}</p>
                <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-slate-400">Student registration</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">{{ $admissionSession->name }}</h1>
                @if ($admissionSession->description)
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">{{ $admissionSession->description }}</p>
                @endif
                <p class="mt-3 inline-flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                    Registration closes {{ $admissionSession->deadline->format('F j, Y · g:i A') }}
                </p>
            </div>
        </div>

        @if (! $isOpen)
            <section class="rounded-2xl border border-slate-200 bg-white px-6 py-16 text-center shadow-sm sm:px-8">
                <div class="mx-auto grid h-16 w-16 place-items-center rounded-2xl bg-slate-100 text-2xl text-slate-500">
                    <i class="fa-solid fa-lock" aria-hidden="true"></i>
                </div>
                <h2 class="mt-6 text-2xl font-semibold text-slate-900">Registration is closed</h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">This session is no longer accepting applications. Please contact the school for the next available registration period.</p>
            </section>
        @else
            @if ($errors->has('form'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                    <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                    {{ $errors->first('form') }}
                </div>
            @endif

            <form wire:submit="submit" class="space-y-6">
                <section class="portal-form-card" aria-labelledby="personal-heading">
                    <div class="portal-section-heading">
                        <span class="portal-section-icon"><i class="fa-solid fa-user" aria-hidden="true"></i></span>
                        <div>
                            <h2 id="personal-heading">Personal information</h2>
                            <p>Tell us about the student applying.</p>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="lg:col-span-2">
                            <label for="first_name" class="portal-label">First Name</label>
                            <input id="first_name" type="text" wire:model="first_name" class="portal-input-field" autocomplete="given-name">
                                @error('first_name') 
                                <p class="portal-error">{{ $message }}</p> 
                                @enderror
                        </div>
                        <div class="lg:col-span-2">
                            <label for="middle_name" class="portal-label">
                                Middle Name <span class="font-normal text-slate-400">(optional)</span>
                            </label>
                            <input id="middle_name" type="text" wire:model="middle_name" class="portal-input-field" autocomplete="additional-name">
                                @error('middle_name') 
                                <p class="portal-error">{{ $message }}</p> 
                                @enderror
                        </div>
                        <div class="lg:col-span-2">
                            <label for="last_name" class="portal-label">Last Name</label>
                            <input id="last_name" type="text" wire:model="last_name" class="portal-input-field" autocomplete="family-name">
                                @error('last_name') 
                                <p class="portal-error">{{ $message }}</p> 
                                @enderror
                        </div>
                        <div class="lg:col-span-2">
                            <label for="extension_name" class="portal-label">
                                Extension Name <span class="font-normal text-slate-400">(optional)</span>
                            </label>
                            <select id="extension_name" wire:model="extension_name" class="portal-input-field">
                                <option value="">None</option>
                                <option>Jr.</option>
                                <option>Sr.</option>
                                <option>II</option>
                                <option>III</option>
                                <option>IV</option>
                            </select>
                            @error('extension_name') 
                            <p class="portal-error">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div>
                            <label for="sex" class="portal-label">Sex</label>
                            <select id="sex" wire:model="sex" class="portal-input-field">
                                <option value="">Select</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Prefer not to say</option>
                            </select>
                            @error('sex') 
                            <p class="portal-error">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div>
                            <label for="birthday" class="portal-label">Birthday</label>
                            <input id="birthday" type="date" wire:model="birthday" class="portal-input-field">
                            @error('birthday') 
                            <p class="portal-error">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div class="lg:col-span-2">
                            <label for="birthplace" class="portal-label">Birthplace</label>
                            <input id="birthplace" type="text" wire:model="birthplace" class="portal-input-field">
                            @error('birthplace') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nationality" class="portal-label">Nationality</label>
                            <select id="nationality" wire:model.live="nationality" class="portal-input-field"><option value="Filipino">Filipino</option><option value="Other">Other</option></select>
                            @error('nationality') <p class="portal-error">{{ $message }}</p> @enderror
                            @if ($nationality === 'Other')
                                <input type="text" wire:model="other_nationality" class="portal-input-field mt-2" placeholder="Enter nationality">
                                @error('other_nationality') <p class="portal-error">{{ $message }}</p> @enderror
                            @endif
                        </div>
                        <div>
                            <label for="civil_status" class="portal-label">Civil Status</label>
                            <select id="civil_status" wire:model="civil_status" class="portal-input-field">
                                <option value="">Select</option>
                                <option>Single</option>
                                <option>Married</option>
                                <option>Widowed</option>
                                <option>Separated</option>
                                <option>Annulled</option>
                            </select>
                            @error('civil_status') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="religion" class="portal-label">Religion</label>
                            <input id="religion" type="text" wire:model="religion" class="portal-input-field">
                            @error('religion') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <section class="portal-form-card" aria-labelledby="contact-heading">
                    <div class="portal-section-heading">
                        <span class="portal-section-icon">
                            <i class="fa-solid fa-address-book" aria-hidden="true"></i>
                        </span>
                        <div>
                            <h2 id="contact-heading">Contact and address</h2>
                            <p>How can the school reach the applicant?</p>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-5">
                        <div>
                            <label for="contact_number" class="portal-label">Contact Number</label>
                            <input id="contact_number" type="tel" wire:model="contact_number" class="portal-input-field" placeholder="09171234567" autocomplete="tel">
                            @error('contact_number') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="address" class="portal-label">Complete Address</label>
                            <textarea id="address" wire:model="address" rows="5" class="portal-input-field" autocomplete="street-address"></textarea>
                            @error('address') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <section class="portal-form-card" aria-labelledby="education-heading">
                    <div class="portal-section-heading">
                        <span class="portal-section-icon"><i class="fa-solid fa-book-open" aria-hidden="true"></i></span>
                        <div>
                            <h2 id="education-heading">Educational background</h2>
                            <p>Share the applicant’s previous school information.</p>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2"><div><label for="lrn" class="portal-label">LRN</label><input id="lrn" type="text" inputmode="numeric" wire:model="lrn" class="portal-input-field" placeholder="12-digit learner reference number">@error('lrn') <p class="portal-error">{{ $message }}</p> @enderror</div><div><label for="last_school_attended" class="portal-label">Last School Attended</label><input id="last_school_attended" type="text" wire:model="last_school_attended" class="portal-input-field">@error('last_school_attended') <p class="portal-error">{{ $message }}</p> @enderror</div><div><label for="last_year_attended" class="portal-label">Last Year Attended</label><input id="last_year_attended" type="text" wire:model="last_year_attended" class="portal-input-field" placeholder="2025-2026">@error('last_year_attended') <p class="portal-error">{{ $message }}</p> @enderror</div><div><label for="highest_educational_attained" class="portal-label">Highest Educational Attained</label><select id="highest_educational_attained" wire:model="highest_educational_attained" class="portal-input-field"><option value="">Select</option><option>Grade 11</option><option>Grade 12</option></select>@error('highest_educational_attained') <p class="portal-error">{{ $message }}</p> @enderror</div></div>
                </section>

                <section class="portal-form-card" aria-labelledby="shs-heading">
                    <div class="portal-section-heading">
                        <span class="portal-section-icon"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></span>
                        <div>
                            <h2 id="shs-heading">Enrollment details</h2>
                            <p>Choose the grade level and strand the student is applying for.</p>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-5 sm:grid-cols-2"><div><label for="shs_level" class="portal-label">Enrolling Grade Level</label><select id="shs_level" wire:model="shs_level" class="portal-input-field"><option value="">Select</option><option>Grade 10</option><option>Grade 11</option></select>@error('shs_level') <p class="portal-error">{{ $message }}</p> @enderror</div><div><label for="strand" class="portal-label">Strand</label><select id="strand" wire:model="strand" class="portal-input-field"><option value="">Select</option><option>ICT</option><option>HUMSS</option><option>ABM</option><option>STEM</option></select>@error('strand') <p class="portal-error">{{ $message }}</p> @enderror</div></div>
                </section>

                <div class="flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:p-6">
                    <p class="max-w-xl text-xs leading-5 text-slate-500">
                        <i class="fa-solid fa-shield-halved mr-1 text-teal-700" aria-hidden="true"></i> 
                        Please review your details before submitting. Your LRN can only be registered once for this session.
                    </p>
                    
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-700 px-6 py-3 text-sm font-semibold text-white transition hover:bg-teal-800 disabled:cursor-wait disabled:opacity-60 sm:w-auto" wire:loading.attr="disabled">
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        <span wire:loading.remove>Submit registration</span>
                        <span wire:loading>Submitting...</span>
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
