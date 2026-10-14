<div class="min-h-screen bg-slate-50">
    <div class="mx-auto max-w-7xl space-y-8 px-4 py-8 sm:px-6 lg:px-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-teal-700">Access control</p>
            <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Admin accounts</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">Create administrator accounts for trusted staff. Public self-registration is disabled.</p>
        </div>

        @if (session('success'))
            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flex items-center gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800" role="alert">
                <i class="fa-solid fa-circle-exclamation" aria-hidden="true"></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)]">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8" aria-labelledby="create-admin-heading">
                <div class="flex items-start gap-4">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-50 text-teal-700"><i class="fa-solid fa-user-plus" aria-hidden="true"></i></span>
                    <div>
                        <h2 id="create-admin-heading" class="text-lg font-semibold text-slate-900">Create an admin</h2>
                        <p class="mt-1 text-sm leading-6 text-slate-500">The new account can manage admission sessions but cannot create other accounts.</p>
                    </div>
                </div>

                <form wire:submit="createAdmin" class="mt-6 space-y-5">
                    <div>
                        <label for="admin-name" class="portal-label">Full name</label>
                        <input id="admin-name" type="text" wire:model="name" class="portal-input-field" autocomplete="name">
                        @error('name') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="admin-email" class="portal-label">Email address</label>
                        <input id="admin-email" type="email" wire:model="email" class="portal-input-field" autocomplete="username">
                        @error('email') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="admin-password" class="portal-label">Password</label>
                        <input id="admin-password" type="password" wire:model.live.debounce.200ms="password" class="portal-input-field" autocomplete="new-password">
                        <div class="mt-3 rounded-xl border border-slate-200 bg-slate-50 p-3" aria-live="polite">
                            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Password requirements</p>
                            <div class="mt-2 grid gap-1.5 text-xs sm:grid-cols-2">
                                <span class="inline-flex items-center gap-2 {{ strlen($password) >= 8 ? 'text-emerald-700' : 'text-slate-500' }}"><i class="fa-solid {{ strlen($password) >= 8 ? 'fa-circle-check' : 'fa-circle' }}" aria-hidden="true"></i>At least 8 characters</span>
                                <span class="inline-flex items-center gap-2 {{ preg_match('/[A-Z]/', $password) ? 'text-emerald-700' : 'text-slate-500' }}"><i class="fa-solid {{ preg_match('/[A-Z]/', $password) ? 'fa-circle-check' : 'fa-circle' }}" aria-hidden="true"></i>One uppercase letter</span>
                                <span class="inline-flex items-center gap-2 {{ preg_match('/[0-9]/', $password) ? 'text-emerald-700' : 'text-slate-500' }}"><i class="fa-solid {{ preg_match('/[0-9]/', $password) ? 'fa-circle-check' : 'fa-circle' }}" aria-hidden="true"></i>One number</span>
                                <span class="inline-flex items-center gap-2 {{ $password !== '' && $password === $password_confirmation ? 'text-emerald-700' : 'text-slate-500' }}"><i class="fa-solid {{ $password !== '' && $password === $password_confirmation ? 'fa-circle-check' : 'fa-circle' }}" aria-hidden="true"></i>Passwords match</span>
                            </div>
                        </div>
                        @error('password') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="admin-password-confirmation" class="portal-label">Confirm password</label>
                        <input id="admin-password-confirmation" type="password" wire:model.live.debounce.200ms="password_confirmation" class="portal-input-field" autocomplete="new-password">
                        @error('password_confirmation') <p class="portal-error">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white transition hover:bg-teal-800 disabled:cursor-wait disabled:opacity-60" wire:loading.attr="disabled">
                        <i class="fa-solid fa-user-plus" aria-hidden="true"></i>
                        <span wire:loading.remove>Create admin account</span>
                        <span wire:loading>Creating...</span>
                    </button>
                </form>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white shadow-sm" aria-labelledby="admin-list-heading">
                <div class="border-b border-slate-100 p-6 sm:p-8">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-teal-700">Trusted users</p>
                            <h2 id="admin-list-heading" class="mt-1 text-xl font-semibold text-slate-900">Current administrators</h2>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">{{ $admins->count() }}</span>
                    </div>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach ($admins as $admin)
                        <div class="flex items-center gap-4 px-6 py-5 sm:px-8">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-teal-50 text-teal-700"><i class="fa-solid {{ $admin->isSuperAdmin() ? 'fa-user-shield' : 'fa-user-gear' }}" aria-hidden="true"></i></span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-slate-900">{{ $admin->name }}</p>
                                <p class="truncate text-sm text-slate-500">{{ $admin->email }}</p>
                            </div>
                            <span class="shrink-0 rounded-full px-3 py-1 text-xs font-bold {{ $admin->isSuperAdmin() ? 'bg-amber-50 text-amber-700' : 'bg-teal-50 text-teal-700' }}">{{ $admin->isSuperAdmin() ? 'SUPER ADMIN' : 'ADMIN' }}</span>
                            @if (! $admin->isSuperAdmin())
                                <button
                                    type="button"
                                    wire:click="deleteAdmin({{ $admin->id }})"
                                    wire:confirm="Delete {{ $admin->name }}'s admin account?"
                                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-rose-600 transition hover:bg-rose-50 hover:text-rose-700 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2"
                                    aria-label="Delete {{ $admin->name }}'s admin account"
                                    title="Delete admin account"
                                >
                                    <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</div>
