<div class="min-h-screen bg-slate-50">
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-teal-700">School portal</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Dashboard</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">See how enrollment demand is distributed across grade levels and strands.</p>
            </div>

            @if (auth()->user()->isAdmin())
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <label for="dashboard-session" class="text-xs font-bold uppercase tracking-wider text-slate-500">Session</label>
                    <select id="dashboard-session" wire:model.live="selectedSessionId" class="portal-input-field min-w-64">
                        @forelse ($sessions as $session)
                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                        @empty
                            <option value="">No sessions yet</option>
                        @endforelse
                    </select>
                </div>
            @endif
        </div>

        @if (! auth()->user()->isAdmin())
            <div class="rounded-3xl bg-gradient-to-br from-teal-800 to-cyan-700 p-6 text-white shadow-lg shadow-teal-900/10 sm:p-8">
                <div class="flex items-start gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/15 text-xl"><i class="fa-solid fa-circle-info" aria-hidden="true"></i></span>
                    <div>
                        <h2 class="text-2xl font-semibold">Your account is ready</h2>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-teal-50">Use the registration link shared by your school to submit an application. No additional account setup is required for enrollment.</p>
                    </div>
                </div>
            </div>
        @elseif (! $selectedSession)
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center shadow-sm">
                <div class="mx-auto grid h-14 w-14 place-items-center rounded-2xl bg-teal-50 text-2xl text-teal-700"><i class="fa-solid fa-chart-column" aria-hidden="true"></i></div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">No session data yet</h2>
                <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Create a session and share its enrollment link to start seeing grade and strand data here.</p>
                <a href="{{ route('sessions.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800"><i class="fa-solid fa-calendar-plus" aria-hidden="true"></i> Manage sessions</a>
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-teal-700"><i class="fa-solid fa-users" aria-hidden="true"></i></span>
                    <p class="mt-5 text-xs font-bold uppercase tracking-wider text-slate-400">Selected session</p>
                    <h2 class="mt-1 truncate text-lg font-semibold text-slate-900" title="{{ $selectedSession->name }}">{{ $selectedSession->name }}</h2>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700"><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i></span>
                    <p class="mt-5 text-xs font-bold uppercase tracking-wider text-slate-400">Total enrolled</p>
                    <p class="mt-1 text-3xl font-semibold text-slate-900">{{ $totalEnrollments }}</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
                    <p class="mt-5 text-xs font-bold uppercase tracking-wider text-slate-400">Session status</p>
                    <p class="mt-1 text-lg font-semibold {{ $selectedSession->effectiveStatus()->value === 'ACTIVE' ? 'text-emerald-700' : 'text-slate-600' }}">{{ $selectedSession->effectiveStatus()->value }}</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="grade-chart-heading">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">Distribution</p>
                            <h2 id="grade-chart-heading" class="mt-1 text-xl font-semibold text-slate-900">By grade level</h2>
                        </div>
                        <i class="fa-solid fa-chart-column text-xl text-teal-600" aria-hidden="true"></i>
                    </div>
                    <div class="mt-8 space-y-6">
                        @foreach ($gradeCounts as $grade => $count)
                            <div>
                                <div class="mb-2 flex items-center justify-between text-sm"><span class="font-semibold text-slate-700">{{ $grade }}</span><span class="font-bold text-slate-900">{{ $count }}</span></div>
                                <div class="h-3 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-teal-600 transition-all duration-500" style="width: {{ ($count / $gradeMax) * 100 }}%"></div></div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="strand-chart-heading">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">Distribution</p>
                            <h2 id="strand-chart-heading" class="mt-1 text-xl font-semibold text-slate-900">By strand</h2>
                        </div>
                        <i class="fa-solid fa-chart-simple text-xl text-cyan-600" aria-hidden="true"></i>
                    </div>
                    <div class="mt-8 space-y-6">
                        @foreach ($strandCounts as $strand => $count)
                            <div>
                                <div class="mb-2 flex items-center justify-between text-sm"><span class="font-semibold text-slate-700">{{ $strand }}</span><span class="font-bold text-slate-900">{{ $count }}</span></div>
                                <div class="h-3 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-cyan-600 transition-all duration-500" style="width: {{ ($count / $strandMax) * 100 }}%"></div></div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        @endif
    </div>
</div>
