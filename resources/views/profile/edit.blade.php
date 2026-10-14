<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-teal-50 text-teal-700">
                <i class="fa-solid fa-user-gear" aria-hidden="true"></i>
            </span>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-teal-700">Account center</p>
                <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Profile settings</h2>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-teal-800 to-cyan-700 p-6 text-white shadow-lg shadow-teal-900/10 sm:p-8">
            <div class="absolute -right-16 -top-20 h-64 w-64 rounded-full border border-white/15"></div>
            <div class="absolute -bottom-28 right-20 h-72 w-72 rounded-full border border-white/10"></div>
            <div class="relative flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-5">
                    <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-3xl bg-white/15 text-2xl font-bold uppercase shadow-inner ring-1 ring-white/20">
                        {{ collect(explode(' ', trim($user->name)))->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('') }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-teal-100">{{ $user->isSuperAdmin() ? 'Super administrator' : ($user->isAdmin() ? 'Administrator' : 'Portal user') }}</p>
                        <h1 class="mt-1 text-3xl font-semibold tracking-tight">{{ $user->name }}</h1>
                        <p class="mt-2 inline-flex items-center gap-2 text-sm text-teal-50"><i class="fa-solid fa-envelope" aria-hidden="true"></i>{{ $user->email }}</p>
                    </div>
                </div>
                <div class="relative rounded-2xl bg-white/10 px-4 py-3 ring-1 ring-white/15 sm:min-w-44">
                    <p class="text-xs font-semibold uppercase tracking-wider text-teal-100">Member since</p>
                    <p class="mt-1 font-semibold">{{ $user->created_at?->format('M Y') ?? 'Recently' }}</p>
                </div>
            </div>
        </section>

        @if (session('status') === 'profile-updated')
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                Your profile information was saved.
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1.35fr)_minmax(20rem,0.65fr)]">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mb-7 flex items-start gap-4 border-b border-slate-100 pb-6">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-700"><i class="fa-solid fa-id-card" aria-hidden="true"></i></span>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Personal information</h2>
                        <p class="mt-1 text-sm text-slate-500">Keep your name and email address up to date.</p>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form')
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mb-7 flex items-start gap-4 border-b border-slate-100 pb-6">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-700"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Password</h2>
                        <p class="mt-1 text-sm text-slate-500">Use a strong password to protect your account.</p>
                    </div>
                </div>
                @include('profile.partials.update-password-form')
            </section>
        </div>

        <section class="rounded-2xl border border-rose-200 bg-rose-50/60 p-6 shadow-sm sm:p-8">
            <div class="flex items-start gap-4">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-rose-100 text-rose-700"><i class="fa-solid fa-triangle-exclamation" aria-hidden="true"></i></span>
                <div class="min-w-0 flex-1">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
