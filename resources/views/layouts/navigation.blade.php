<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-900" aria-label="{{ config('app.name', 'School Portal') }} dashboard">
                    <span class="grid h-9 w-9 place-items-center rounded-xl bg-teal-700 text-white shadow-sm">
                        <i class="fa-solid fa-school" aria-hidden="true"></i>
                    </span>
                    <span class="hidden text-sm font-bold tracking-tight sm:inline">{{ config('app.name', 'Student Portal') }}</span>
                </a>

                <div class="hidden items-center gap-1 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fa-solid fa-chart-line mr-2 text-xs" aria-hidden="true"></i>
                        Dashboard
                    </x-nav-link>

                    @if (auth()->user()->isAdmin())
                        <x-nav-link :href="route('sessions.index')" :active="request()->routeIs('sessions.*')">
                            <i class="fa-solid fa-calendar-check mr-2 text-xs" aria-hidden="true"></i>
                            Sessions
                        </x-nav-link>
                    @endif

                    @if (auth()->user()->isSuperAdmin())
                        <x-nav-link :href="route('admin.accounts.index')" :active="request()->routeIs('admin.accounts.*')">
                            <i class="fa-solid fa-user-shield mr-2 text-xs" aria-hidden="true"></i>
                            Admin accounts
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden items-center sm:flex">
                <x-dropdown align="right" width="48" contentClasses="bg-white py-1">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-transparent px-3 py-2 text-sm font-semibold text-slate-600 transition hover:border-slate-200 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2">
                            <i class="fa-solid fa-circle-user text-base text-teal-700" aria-hidden="true"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400" aria-hidden="true"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user-gear mr-2 text-xs" aria-hidden="true"></i>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-2 text-xs" aria-hidden="true"></i>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <button @click="open = !open" class="inline-flex items-center justify-center rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-600 sm:hidden" aria-label="Toggle navigation menu" :aria-expanded="open.toString()">
                <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="border-t border-slate-100 bg-white sm:hidden" style="display: none;">
        <div class="space-y-1 px-4 py-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-chart-line mr-2 text-xs" aria-hidden="true"></i>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('sessions.index')" :active="request()->routeIs('sessions.*')">
                    <i class="fa-solid fa-calendar-check mr-2 text-xs" aria-hidden="true"></i>
                    {{ __('Sessions') }}
                </x-responsive-nav-link>
            @endif

            @if (auth()->user()->isSuperAdmin())
                <x-responsive-nav-link :href="route('admin.accounts.index')" :active="request()->routeIs('admin.accounts.*')">
                    <i class="fa-solid fa-user-shield mr-2 text-xs" aria-hidden="true"></i>
                    {{ __('Admin accounts') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-slate-100 px-4 py-4">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-user text-2xl text-teal-700" aria-hidden="true"></i>
                <div>
                    <div class="font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    <i class="fa-solid fa-user-gear mr-2 text-xs" aria-hidden="true"></i>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2 text-xs" aria-hidden="true"></i>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
