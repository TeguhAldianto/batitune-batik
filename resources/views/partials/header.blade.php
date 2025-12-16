<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-indigo-50 transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <a href="/" class="flex items-center gap-2">
                    <img src="{{ asset('storage/img/batitune.png') }}" alt="Batik Negeri Lasem"
                        class="h-8 w-8 rounded-lg object-cover border border-indigo-200">
                    <span
                        class="text-xl font-bold text-gray-900 tracking-tight font-['Playfair Display']">BATITUNE</span>
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-8">
                <a href="/"
                    class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-indigo-50">Beranda</a>
                <a href="/#produk"
                    class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-indigo-50">Produk</a>
                <a href="/#tentang"
                    class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-indigo-50">Tentang</a>
                <a href="/#kontak"
                    class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg text-sm font-medium transition-colors hover:bg-indigo-50">Kontak</a>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-4">
                @auth
                    @php /** @var \App\Models\User|null $user */ $user = Auth::user(); @endphp
                    <a href="{{ route('keranjang.index') }}"
                        class="relative text-gray-500 hover:text-indigo-600 transition-colors p-1">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span id="cart-badge"
                            class="absolute -top-1 -right-2 h-5 w-5 bg-purple-600 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">0</span>
                    </a>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none pl-2">
                            <span class="max-w-[100px] truncate">{{ $user->name }}</span>
                            <div
                                class="h-8 w-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center border border-indigo-200">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2 z-20 border border-indigo-50 transform origin-top-right transition-all">
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Dashboard</a>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">Profil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-lg text-sm font-medium transition">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-5 py-2 bg-indigo-600 text-white rounded-full text-sm font-medium hover:bg-indigo-700 transition shadow-md shadow-indigo-500/20">Daftar</a>
                    @endif
                @endauth

                <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-colors">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <div class="md:hidden">
                    <button class="text-gray-600 hover:text-indigo-600 p-1">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    (function() {
        const toggleButton = document.getElementById('theme-toggle');
        if (!toggleButton) return;

        toggleButton.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' :
                'light');
        });

        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    })();
</script>
