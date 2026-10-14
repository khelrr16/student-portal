<x-guest-layout>
    <main class="min-h-screen bg-slate-50 px-6 py-10 text-slate-900 sm:px-10">
        <div class="mx-auto flex min-h-[80vh] max-w-6xl flex-col justify-center">
            <div class="grid items-center gap-12 lg:grid-cols-[1.1fr_0.9fr]">
                <div>
                    <div class="inline-flex items-center gap-3 text-sm font-semibold uppercase tracking-[0.2em] text-teal-700">
                        <i class="fa-solid fa-school" aria-hidden="true"></i>
                        {{ config('app.name', 'School Portal') }}
                    </div>
                    <h1 class="mt-6 max-w-3xl text-4xl font-semibold tracking-tight text-slate-900 sm:text-6xl">A simpler path to your next school chapter.</h1>
                    <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-600">Manage admission sessions and collect complete SHS registration details through a clear, professional enrollment experience.</p>
                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i> Open dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-teal-800"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"></i> Sign in</a>
                        @endauth
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-teal-800 to-cyan-700 p-8 text-white shadow-xl shadow-teal-900/15 sm:p-12">
                    <div class="absolute -right-12 -top-12 h-48 w-48 rounded-full border border-white/20"></div>
                    <div class="absolute -bottom-20 -left-10 h-56 w-56 rounded-full border border-white/10"></div>
                    <div class="relative">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15 text-2xl"><i class="fa-solid fa-clipboard-check" aria-hidden="true"></i></span>
                        <h2 class="mt-8 text-2xl font-semibold">Ready when you are.</h2>
                        <p class="mt-3 leading-7 text-teal-50">Your school’s public registration link takes you straight to the form. Complete it once, then keep your reference code for your records.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-guest-layout>
