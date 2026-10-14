<div class="min-h-screen bg-slate-50">
    <div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Admissions workspace</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Registration sessions</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Create application windows, share public forms, and keep every enrolled student tied to the right session.</p>
            </div>

            <button type="button" wire:click="$set('showCreateForm', true)" class="inline-flex items-center justify-center gap-2 rounded-xl bg-teal-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                New session
            </button>
        </div>

        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($showCreateForm)
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="create-session-heading">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">New intake</p>
                        <h2 id="create-session-heading" class="mt-1 text-xl font-semibold text-slate-900">Create a registration session</h2>
                    </div>
                    <button type="button" wire:click="$set('showCreateForm', false)" class="grid h-9 w-9 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close form">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>

                <form wire:submit="createSession" class="mt-6 grid gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="session-name" class="portal-label">Session name</label>
                        <input id="session-name" type="text" wire:model="name" class="portal-input-field" placeholder="e.g. Senior High School Admission 2027" autofocus>
                        @error('name') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="session-description" class="portal-label">Description <span class="font-normal text-slate-400">(optional)</span></label>
                        <textarea id="session-description" wire:model="description" rows="3" class="portal-input-field" placeholder="Tell applicants what this registration window is for."></textarea>
                        @error('description') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="session-deadline" class="portal-label">Registration deadline</label>
                        <input id="session-deadline" type="datetime-local" wire:model="deadline" class="portal-input-field">
                        @error('deadline') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="session-status" class="portal-label">Initial status</label>
                        <select id="session-status" wire:model="status" class="portal-input-field">
                            <option value="ACTIVE">ACTIVE — accepting applications</option>
                            <option value="ENDED">ENDED — closed</option>
                        </select>
                        @error('status') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 md:col-span-2">
                        <button type="button" wire:click="$set('showCreateForm', false)" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100">Cancel</button>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800 disabled:cursor-wait disabled:opacity-60" wire:loading.attr="disabled">
                            <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                            <span wire:loading.remove>Create session</span>
                            <span wire:loading>Creating...</span>
                        </button>
                    </div>
                </form>
            </section>
        @endif

        @if ($sessions->isEmpty())
            <section class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-teal-50 text-2xl text-teal-700">
                    <i class="fa-solid fa-calendar-plus" aria-hidden="true"></i>
                </div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">No sessions yet</h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Create your first registration session to generate a public enrollment link.</p>
            </section>
        @else
            <div class="grid gap-5 lg:grid-cols-2">
                @foreach ($sessions as $session)
                    @php($sessionStatus = $session->effectiveStatus()->value)
                    <article class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:border-teal-200 hover:shadow-md">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">{{ $session->deadline->format('M j, Y') }}</p>
                                <h2 class="mt-2 truncate text-xl font-semibold text-slate-900">{{ $session->name }}</h2>
                            </div>
                            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold {{ $sessionStatus === 'ACTIVE' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                <i class="fa-solid {{ $sessionStatus === 'ACTIVE' ? 'fa-circle-play' : 'fa-circle-check' }}" aria-hidden="true"></i>
                                {{ $sessionStatus }}
                            </span>
                        </div>

                        @if ($session->description)
                            <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-500">{{ $session->description }}</p>
                        @endif

                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="rounded-xl bg-slate-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Enrolled</p>
                                <p class="mt-1 text-xl font-semibold text-slate-900">{{ $session->enrollments_count }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Deadline</p>
                                <p class="mt-1 text-sm font-semibold text-slate-900">{{ $session->deadline->format('M j, g:i A') }}</p>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-between gap-3 border-t border-slate-100 pt-5">
                            <a href="{{ route('sessions.show', $session) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teal-700 transition hover:text-teal-900">
                                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                View / edit
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                            @if ($sessionStatus === 'ACTIVE')
                                <button type="button" wire:click="endSession({{ $session->id }})" wire:confirm="End this registration session?" class="text-xs font-semibold text-slate-400 transition hover:text-rose-600">End session</button>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
