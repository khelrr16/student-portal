<div class="min-h-screen bg-slate-50">
    <div class="mx-auto flex min-h-screen max-w-2xl items-center justify-center px-4 py-12 sm:px-6">
        <section class="w-full rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-sm sm:p-12">
            <div class="mx-auto grid h-20 w-20 place-items-center rounded-3xl bg-emerald-50 text-3xl text-emerald-600">
                <i class="fa-solid fa-check" aria-hidden="true"></i>
            </div>
            <p class="mt-8 text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Registration received</p>
            <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">You’re all set.</h1>
            <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-500">Your enrollment for <strong class="font-semibold text-slate-700">{{ $admissionSession->name }}</strong> has been recorded. Keep this reference code for your records.</p>

            <div class="mt-8 rounded-2xl bg-slate-50 p-5">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Enrollment reference</p>
                <p class="mt-2 font-mono text-2xl font-bold tracking-wider text-teal-800">{{ $enrollment->reference_code }}</p>
            </div>

            <p class="mt-8 text-xs leading-5 text-slate-400"><i class="fa-solid fa-lock mr-1 text-teal-600" aria-hidden="true"></i> Keep this code private. The school may request it when you follow up.</p>
        </section>
    </div>
</div>
