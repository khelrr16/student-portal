<div class="min-h-screen bg-slate-50">
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <a href="{{ route('sessions.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-teal-700">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            All sessions
        </a>

        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
        @endif

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                <div class="max-w-2xl">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-bold {{ $admissionSession->effectiveStatus()->value === 'ACTIVE' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            <i class="fa-solid {{ $admissionSession->effectiveStatus()->value === 'ACTIVE' ? 'fa-circle-play' : 'fa-circle-check' }}" aria-hidden="true"></i>
                            {{ $admissionSession->effectiveStatus()->value }}
                        </span>
                        <span class="text-sm text-slate-400">Deadline {{ $admissionSession->deadline->format('F j, Y · g:i A') }}</span>
                    </div>
                    <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900">{{ $admissionSession->name }}</h1>
                    @if ($admissionSession->description)
                        <p class="mt-3 text-sm leading-7 text-slate-500">{{ $admissionSession->description }}</p>
                    @endif
                </div>

                <div class="flex flex-wrap gap-3 lg:justify-end">
                    <button type="button" wire:click="startEditing" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-700">
                        <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                        Edit session
                    </button>
                    @if ($admissionSession->effectiveStatus()->value === 'ACTIVE')
                        <button type="button" wire:click="endSession" wire:confirm="End this registration session?" class="inline-flex items-center gap-2 rounded-xl border border-rose-200 px-4 py-2.5 text-sm font-semibold text-rose-700 transition hover:bg-rose-50">
                            <i class="fa-solid fa-stop" aria-hidden="true"></i>
                            End session
                        </button>
                    @endif
                    <a href="{{ $registrationUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-teal-800">
                        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                        Open form
                    </a>
                </div>
            </div>

            <div x-data="{ copied: false }" class="mt-8 rounded-xl border border-teal-100 bg-teal-50 p-4">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-teal-800">Public registration link</p>
                        <p class="mt-1 truncate text-sm text-teal-900">{{ $registrationUrl }}</p>
                    </div>
                    <button type="button" @click="navigator.clipboard.writeText(@js($registrationUrl)); copied = true; setTimeout(() => copied = false, 1800)" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-white px-3 py-2 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-200 transition hover:bg-teal-100">
                        <i class="fa-solid" :class="copied ? 'fa-check' : 'fa-copy'" aria-hidden="true"></i>
                        <span x-text="copied ? 'Copied' : 'Copy link'"></span>
                    </button>
                </div>
            </div>

            @if ($showEditForm)
                <form wire:submit="updateSession" class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5 sm:p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-teal-700">Session settings</p>
                            <h2 class="mt-1 text-lg font-semibold text-slate-900">Edit session details</h2>
                        </div>
                        <button type="button" wire:click="cancelEditing" class="grid h-9 w-9 place-items-center rounded-lg text-slate-400 transition hover:bg-white hover:text-slate-700" aria-label="Close edit form">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="edit-session-name" class="portal-label">Session name</label>
                            <input id="edit-session-name" type="text" wire:model="editName" class="portal-input-field">
                            @error('editName') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="edit-session-description" class="portal-label">Description <span class="font-normal text-slate-400">(optional)</span></label>
                            <textarea id="edit-session-description" wire:model="editDescription" rows="3" class="portal-input-field"></textarea>
                            @error('editDescription') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="edit-session-deadline" class="portal-label">Registration deadline</label>
                            <input id="edit-session-deadline" type="datetime-local" wire:model="editDeadline" class="portal-input-field">
                            @error('editDeadline') <p class="portal-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-end justify-end">
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-teal-800 md:w-auto" wire:loading.attr="disabled">
                                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                                Save changes
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 border-b border-slate-100 p-6 sm:flex-row sm:items-center sm:justify-between sm:p-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">Student records</p>
                    <h2 class="mt-1 text-xl font-semibold text-slate-900">Enrolled students</h2>
                </div>
                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400" aria-hidden="true"></i>
                        <input type="search" wire:model.live.debounce.350ms="search" placeholder="Search name, LRN, or reference" class="portal-input-field pl-9">
                    </div>
                    <button type="button" wire:click="toggleFilters" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-700">
                        <i class="fa-solid fa-filter" aria-hidden="true"></i>
                        Filters
                        <i class="fa-solid fa-chevron-down text-[10px]" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            @if ($showFilters)
                <div class="border-b border-slate-100 bg-slate-50 px-6 py-5 sm:px-8">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <fieldset>
                            <legend class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Grade levels</legend>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($gradeOptions as $grade)
                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition has-[:checked]:border-teal-300 has-[:checked]:bg-teal-50 has-[:checked]:text-teal-800">
                                        <input type="checkbox" wire:model.live="visibleGrades" value="{{ $grade }}" class="rounded border-slate-300 text-teal-700 focus:ring-teal-500">
                                        {{ $grade }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-xs font-bold uppercase tracking-[0.16em] text-slate-500">Strands</legend>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach ($strandOptions as $strand)
                                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 transition has-[:checked]:border-teal-300 has-[:checked]:bg-teal-50 has-[:checked]:text-teal-800">
                                        <input type="checkbox" wire:model.live="visibleStrands" value="{{ $strand }}" class="rounded border-slate-300 text-teal-700 focus:ring-teal-500">
                                        {{ $strand }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>
                </div>
            @endif

            @if ($students->isEmpty())
                <div class="px-6 py-16 text-center sm:px-8">
                    <i class="fa-solid fa-users-slash text-3xl text-slate-300" aria-hidden="true"></i>
                    <p class="mt-4 text-sm font-semibold text-slate-700">No students found</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $search ? 'Try a different search term.' : 'Students will appear here after they submit the public form.' }}</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left">
                        <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-400">
                            <tr>
                                <th class="px-6 py-4 sm:px-8"><button type="button" wire:click="sortBy('last_name')" class="inline-flex items-center gap-2 uppercase tracking-wider transition hover:text-teal-700">Student <i class="fa-solid {{ $sortField === 'last_name' ? ($sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort' }}" aria-hidden="true"></i></button></th>
                                <th class="px-6 py-4"><button type="button" wire:click="sortBy('lrn')" class="inline-flex items-center gap-2 uppercase tracking-wider transition hover:text-teal-700">LRN <i class="fa-solid {{ $sortField === 'lrn' ? ($sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort' }}" aria-hidden="true"></i></button></th>
                                <th class="px-6 py-4"><button type="button" wire:click="sortBy('shs_level')" class="inline-flex items-center gap-2 uppercase tracking-wider transition hover:text-teal-700">Grade <i class="fa-solid {{ $sortField === 'shs_level' ? ($sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort' }}" aria-hidden="true"></i></button></th>
                                <th class="px-6 py-4"><button type="button" wire:click="sortBy('strand')" class="inline-flex items-center gap-2 uppercase tracking-wider transition hover:text-teal-700">Strand <i class="fa-solid {{ $sortField === 'strand' ? ($sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort' }}" aria-hidden="true"></i></button></th>
                                <th class="px-6 py-4"><button type="button" wire:click="sortBy('created_at')" class="inline-flex items-center gap-2 uppercase tracking-wider transition hover:text-teal-700">Submitted <i class="fa-solid {{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? 'fa-sort-up' : 'fa-sort-down') : 'fa-sort' }}" aria-hidden="true"></i></button></th>
                                <th class="px-6 py-4 text-right">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($students as $student)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="whitespace-nowrap px-6 py-4 sm:px-8">
                                        <p class="text-sm font-semibold text-slate-900">{{ $student->fullName() }}</p>
                                        <p class="mt-0.5 text-xs text-slate-500">{{ $student->reference_code }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $student->lrn }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $student->shs_level }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $student->strand }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $student->created_at->format('M j, Y') }}</td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right">
                                        <button type="button" wire:click="selectEnrollment({{ $student->id }})" class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-xs font-bold text-teal-700 transition hover:bg-teal-50">
                                            <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                            View details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-slate-100 px-6 py-4 sm:px-8">{{ $students->links() }}</div>
            @endif
        </section>
    </div>

    @if ($selectedEnrollment)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true" aria-label="Student details">
            <div class="flex min-h-full items-center justify-center bg-slate-900/40 p-4" wire:click="closeEnrollmentDetails">
                <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl sm:p-8" wire:click.stop>
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">Enrollment details</p>
                            <h2 class="mt-2 text-2xl font-semibold text-slate-900">{{ $selectedEnrollment->fullName() }}</h2>
                            <p class="mt-1 text-sm text-slate-500">{{ $selectedEnrollment->reference_code }}</p>
                        </div>
                        <button type="button" wire:click="closeEnrollmentDetails" class="grid h-9 w-9 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Close student details">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                        </button>
                    </div>

                    <div class="mt-7 grid gap-x-6 gap-y-5 sm:grid-cols-2">
                        @foreach ([
                            'Sex' => $selectedEnrollment->sex,
                            'Birthday' => $selectedEnrollment->birthday?->format('F j, Y'),
                            'Birthplace' => $selectedEnrollment->birthplace,
                            'Nationality' => $selectedEnrollment->nationality,
                            'Civil status' => $selectedEnrollment->civil_status,
                            'Religion' => $selectedEnrollment->religion,
                            'Contact number' => $selectedEnrollment->contact_number,
                            'LRN' => $selectedEnrollment->lrn,
                            'Last school attended' => $selectedEnrollment->last_school_attended,
                            'Last year attended' => $selectedEnrollment->last_year_attended,
                            'Highest educational attainment' => $selectedEnrollment->highest_educational_attained,
                            'SHS enrollment' => $selectedEnrollment->shs_level.' · '.$selectedEnrollment->strand,
                        ] as $label => $value)
                            <div>
                                <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">{{ $label }}</dt>
                                <dd class="mt-1 text-sm text-slate-700">{{ $value ?: 'N/A' }}</dd>
                            </div>
                        @endforeach
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-bold uppercase tracking-wider text-slate-400">Address</dt>
                            <dd class="mt-1 text-sm leading-6 text-slate-700">{{ $selectedEnrollment->address }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
