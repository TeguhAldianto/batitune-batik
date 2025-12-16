<nav x-data="{ open: false }"
    class="bg-white/90 dark:bg-slate-900/95 border-b border-slate-200/70 dark:border-slate-800/80 backdrop-blur-md shadow-sm sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            {{-- Logo + Nama Aplikasi --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    {{-- Logo Gradient Ungu --}}
                    <div
                        class="h-9 w-9 rounded-2xl bg-gradient-to-br from-brand to-orange-600 flex items-center justify-center shadow-md shadow-brand/30">
                        <span class="text-white font-bold text-lg">B</span>
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span
                            class="text-sm font-semibold text-slate-900 dark:text-slate-50 tracking-wide group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                            {{ config('app.name', 'UMKM Batik') }}
                        </span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 uppercase tracking-[0.18em]">
                            Platform Batik
                        </span>
                    </div>
                </a>
            </div>

            {{-- Menu utama (desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="nav-link">
                    {{ __('Home') }}
                </x-nav-link>

                @if (Route::has('produk.index'))
                    <x-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.*')" class="nav-link">
                        {{ __('Produk') }}
                    </x-nav-link>
                @endif

                @if (Route::has('keranjang.index'))
                    <x-nav-link :href="route('keranjang.index')" :active="request()->routeIs('keranjang.*')" class="nav-link">
                        {{ __('Keranjang') }}
                    </x-nav-link>
                @endif
            </div>

            {{-- Aksi (user + theme + auth) desktop --}}
            <div class="hidden sm:flex items-center gap-4">
                {{-- Tombol theme toggle --}}
                <button id="theme-toggle" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 transition"
                    type="button">
                    <span class="sr-only">Ganti tema</span>
                    <svg class="h-5 w-5 text-slate-700 dark:text-slate-200" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M18.364 18.364l-.707-.707M6.343 6.343L5.636 5.636M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                @auth
                    @php /** @var \App\Models\User|null $user */ $user = Auth::user(); @endphp
                    {{-- Dropdown user --}}
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-1.5 border border-slate-200 dark:border-slate-700 rounded-full text-sm text-slate-700 dark:text-slate-200 bg-white/80 dark:bg-slate-900/80 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                                <div
                                    class="h-7 w-7 rounded-full bg-gradient-to-br from-brand to-orange-600 flex items-center justify-center text-xs font-semibold text-white uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <span class="max-w-[120px] truncate">{{ $user->name }}</span>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.25a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content" class="bg-white dark:bg-slate-900">
                            @if (Route::has('dashboard'))
                                <x-dropdown-link :href="route('dashboard')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                            @endif
                            @if (Route::has('profile.edit'))
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth

                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 transition nav-link">
                        {{ __('Masuk') }}
                    </a>
                    @if (Route::has('register'))
                        {{-- Tombol Daftar dengan tema ungu --}}
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center rounded-full border border-indigo-500/70 text-xs font-semibold px-3 py-1.5 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-500 hover:text-white transition bg-indigo-50/70 dark:bg-slate-900/60">
                            {{ __('Daftar') }}
                        </a>
                    @endif
                @endguest
            </div>

            {{-- Tombol menu mobile --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu mobile --}}
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden border-t border-slate-200 dark:border-slate-700 bg-white/95 dark:bg-slate-900/95 backdrop-blur">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @if (Route::has('produk.index'))
                <x-responsive-nav-link :href="route('produk.index')" :active="request()->routeIs('produk.*')">
                    {{ __('Produk') }}
                </x-responsive-nav-link>
            @endif

            @if (Route::has('keranjang.index'))
                <x-responsive-nav-link :href="route('keranjang.index')" :active="request()->routeIs('keranjang.*')">
                    {{ __('Keranjang') }}
                </x-responsive-nav-link>
            @endif
        </div>

        @auth
            @php /** @var \App\Models\User|null $user */ $user = Auth::user(); @endphp
            <div class="pt-4 pb-3 border-t border-slate-200 dark:border-slate-700">
                <div class="px-4">
                    <div class="font-medium text-base text-slate-900 dark:text-slate-100">{{ $user->name }}</div>
                    <div class="font-medium text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    @if (Route::has('dashboard'))
                        <x-responsive-nav-link :href="route('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    @endif
                    @if (Route::has('profile.edit'))
                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <div class="pt-2 pb-4 border-t border-slate-200 dark:border-slate-700 flex flex-col gap-2 px-4">
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-slate-700 dark:text-slate-200 hover:text-indigo-500 dark:hover:text-indigo-400 transition">
                    {{ __('Masuk') }}
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center rounded-full border border-indigo-500 text-xs font-semibold px-3 py-1.5 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-500 hover:text-white transition bg-indigo-50/70 dark:bg-slate-900/60">
                        {{ __('Daftar') }}
                    </a>
                @endif
            </div>
        @endguest
    </div>

    <style>
        /* Mengubah garis bawah menu menjadi gradient ungu */
        .nav-link {
            position: relative;
            padding-bottom: 4px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            border-radius: 999px;
            bottom: 0;
            left: 0;
            background: linear-gradient(to right, #f97316, #ff7a18);
            /* Brand (orange) */
            transition: width 0.25s ease-in-out;
        }

        .nav-link:hover::after,
        .nav-link[aria-current="page"]::after {
            width: 100%;
        }
    </style>
</nav>
