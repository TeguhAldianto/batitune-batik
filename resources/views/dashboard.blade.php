<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Batik Nusantara - Warisan Budaya Indonesia</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Playfair Display', 'serif'],
                    },
                    colors: {
                        primary: {
                            50: '#fdf5e9',
                            100: '#fbe8cf',
                            200: '#f7d0a1',
                            300: '#f2b26d',
                            400: '#ea8b36',
                            500: '#d86a15',
                            600: '#b65010',
                            700: '#8f3c11',
                            800: '#733112',
                            900: '#5f2a12'
                        }
                    },
                    boxShadow: {
                        'soft': '0 18px 45px rgba(15,23,42,0.18)'
                    }
                }
            }
        }
    </script>

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap');

        .batik-pattern {
            background-image:
                radial-gradient(circle at 20% 80%, rgba(217, 119, 6, 0.08) 0%, transparent 55%),
                radial-gradient(circle at 80% 15%, rgba(79, 70, 229, 0.12) 0%, transparent 55%),
                radial-gradient(circle at 40% 40%, rgba(148, 163, 184, 0.15) 0%, transparent 55%);
        }

        .hero-gradient {
            background: radial-gradient(circle at top left, #f97316 0, transparent 55%),
                radial-gradient(circle at bottom right, #1e40af 0, transparent 55%),
                linear-gradient(135deg, #020617 0%, #111827 40%, #312e81 100%);
            background-size: cover;
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-18px) rotate(2deg);
            }
        }

        .product-card {
            transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 28px 65px rgba(15, 23, 42, 0.28);
        }

        .text-gradient {
            background: linear-gradient(120deg, #f97316, #ea580c, #facc15);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.9));
            backdrop-filter: blur(18px);
        }

        /* Modal Transitions */
        #product-modal-backdrop.hidden,
        #product-modal.hidden {
            display: none;
        }

        #product-modal-backdrop {
            transition: opacity 0.3s ease-in-out;
        }

        #product-modal {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .modal-enter {
            opacity: 0;
            transform: scale(0.95) translateY(20px);
        }

        .modal-enter-active {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        .modal-leave-active {
            opacity: 0;
            transform: scale(0.95) translateY(20px);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-slate-950 font-sans transition-colors duration-300">

    <!-- NAVBAR -->
    <nav
        class="bg-white/90 dark:bg-slate-950/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-200/60 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div
                        class="h-9 w-9 rounded-full bg-gradient-to-br from-amber-500 via-orange-500 to-primary-700 flex items-center justify-center text-white shadow-soft">
                        <i class="fa-solid fa-swatchbook text-sm"></i>
                    </div>
                    <div>
                        <a href="{{ route('home') }}"
                            class="text-xl md:text-2xl font-bold text-gradient font-display block leading-tight">
                            Batik Nusantara
                        </a>
                        <p
                            class="text-[11px] uppercase tracking-[0.25em] text-slate-400 dark:text-slate-500 hidden sm:block">
                            UMKM • Handmade • Lokal
                        </p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-2 lg:space-x-6 text-sm font-medium">
                    <a href="{{ route('home') }}"
                        class="relative px-3 py-2 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-amber-300 group">
                        <span>Beranda</span>
                        <span
                            class="absolute left-3 right-3 -bottom-1 h-[2px] bg-gradient-to-r from-amber-500 to-primary-600 scale-x-0 group-hover:scale-x-100 origin-left transition-transform"></span>
                    </a>
                    <a href="#produk"
                        class="relative px-3 py-2 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-amber-300 group">
                        <span>Produk</span>
                        <span
                            class="absolute left-3 right-3 -bottom-1 h-[2px] bg-gradient-to-r from-amber-500 to-primary-600 scale-x-0 group-hover:scale-x-100 origin-left transition-transform"></span>
                    </a>
                    <a href="#tentang"
                        class="relative px-3 py-2 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-amber-300 group">
                        <span>Tentang</span>
                        <span
                            class="absolute left-3 right-3 -bottom-1 h-[2px] bg-gradient-to-r from-amber-500 to-primary-600 scale-x-0 group-hover:scale-x-100 origin-left transition-transform"></span>
                    </a>
                    <a href="#kontak"
                        class="relative px-3 py-2 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-amber-300 group">
                        <span>Kontak</span>
                        <span
                            class="absolute left-3 right-3 -bottom-1 h-[2px] bg-gradient-to-r from-amber-500 to-primary-600 scale-x-0 group-hover:scale-x-100 origin-left transition-transform"></span>
                    </a>

                    <button onclick="toggleTheme()"
                        class="ml-2 p-2 rounded-full text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 transition">
                        <i class="fas fa-sun hidden dark:block"></i>
                        <i class="fas fa-moon block dark:hidden"></i>
                    </button>

                    @auth
                        {{-- Icon Keranjang --}}
                        <a href="{{ route('keranjang.index') }}"
                            class="relative text-slate-600 dark:text-slate-200 hover:text-primary-600 dark:hover:text-amber-300 px-3 py-2 transition">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if (auth()->user()->pelanggan && auth()->user()->pelanggan->keranjang)
                                <span
                                    class="absolute -top-0.5 -right-0.5 h-4 w-4 bg-red-600 text-white text-[10px] rounded-full flex items-center justify-center ring-2 ring-white dark:ring-slate-900">
                                    {{ auth()->user()->pelanggan->keranjang->itemKeranjangs->sum('kuantitas') }}
                                </span>
                            @endif
                        </a>

                        {{-- User Dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 text-sm font-medium text-slate-700 dark:text-slate-100 hover:text-primary-600 dark:hover:text-amber-300 focus:outline-none">
                                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                                <div
                                    class="h-8 w-8 rounded-full bg-gradient-to-br from-amber-500 to-primary-700 flex items-center justify-center text-white text-xs font-bold shadow-md">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-120"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-52 bg-white dark:bg-slate-900 rounded-2xl shadow-xl py-2 z-20 ring-1 ring-slate-900/5 dark:ring-white/10">
                                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800">
                                    <p class="text-xs text-slate-400 dark:text-slate-500">Masuk sebagai</p>
                                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate">
                                        {{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70">
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2.5 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/70">
                                    Profil
                                </a>
                                <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-slate-600 dark:text-slate-200 hover:text-primary-600 px-3 py-2 font-medium text-sm transition">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-gradient-to-r from-amber-500 via-orange-500 to-primary-700 text-white px-5 py-2 rounded-full text-xs font-semibold hover:shadow-soft hover:-translate-y-0.5 transition-all">
                                Daftar Gratis
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Mobile -->
                <div class="md:hidden flex items-center gap-3">
                    <button onclick="toggleTheme()" class="text-slate-500 dark:text-slate-300 focus:outline-none">
                        <i class="fas fa-sun hidden dark:block"></i>
                        <i class="fas fa-moon block dark:hidden"></i>
                    </button>
                    @auth
                        <a href="{{ route('keranjang.index') }}" class="relative text-slate-600 dark:text-slate-100">
                            <i class="fas fa-shopping-bag text-lg"></i>
                            @if (auth()->user()->pelanggan && auth()->user()->pelanggan->keranjang)
                                <span
                                    class="absolute -top-1 -right-1 h-4 w-4 bg-red-600 text-white text-[10px] rounded-full flex items-center justify-center ring-2 ring-slate-50 dark:ring-slate-900">
                                    {{ auth()->user()->pelanggan->keranjang->itemKeranjangs->sum('kuantitas') }}
                                </span>
                            @endif
                        </a>
                    @endauth
                    <button class="text-slate-700 dark:text-slate-200 hover:text-primary-500">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-gradient relative overflow-hidden">
        <div class="absolute inset-0 batik-pattern opacity-40"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text -->
                <div class="space-y-7">
                    <div
                        class="inline-flex items-center gap-2 rounded-full bg-black/30 text-amber-200 px-4 py-1 text-xs font-medium backdrop-blur">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>100% Buatan Pengrajin Lokal • UMKM Indonesia</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight font-display">
                        Batik Premium,
                        <span class="text-amber-300">Dari Nusantara</span><br>
                        Untuk Gaya Sehari-hari
                    </h1>

                    <p class="text-base md:text-lg text-slate-100/80 max-w-xl">
                        Pilih koleksi batik autentik dengan sentuhan modern. Nyaman dipakai, cocok untuk kerja, pesta,
                        maupun acara keluarga – mendukung pengrajin lokal Indonesia.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#produk"
                            class="inline-flex items-center justify-center gap-2 bg-amber-400 text-slate-900 px-7 py-3.5 rounded-full font-semibold text-sm md:text-base shadow-soft hover:bg-amber-300 hover:-translate-y-0.5 transition-all">
                            <i class="fas fa-shopping-bag"></i>
                            Jelajahi Koleksi
                        </a>
                        <a href="#tentang"
                            class="inline-flex items-center justify-center gap-2 border border-slate-500/60 text-slate-100 px-7 py-3.5 rounded-full font-semibold text-sm md:text-base hover:bg-slate-900/30 transition-all">
                            <i class="fas fa-play-circle text-amber-300"></i>
                            Kenali Batik Kami
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-4 text-xs md:text-sm text-slate-200/90 max-w-md pt-2">
                        <div class="flex flex-col">
                            <span class="font-semibold text-base md:text-lg text-amber-300">+500</span>
                            <span>Pelanggan puas di seluruh Indonesia</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-base md:text-lg text-amber-300">100%</span>
                            <span>Kain lembut & nyaman dipakai lama</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-semibold text-base md:text-lg text-amber-300">UMKM</span>
                            <span>Dukung pengrajin batik lokal</span>
                        </div>
                    </div>
                </div>

                <!-- Visual -->
                <div class="relative mt-6 md:mt-0">
                    <div
                        class="float-animation relative rounded-3xl glass border border-white/10 shadow-soft overflow-hidden">
                        <div
                            class="absolute inset-0 opacity-20 mix-blend-soft-light bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-amber-500 via-transparent to-transparent">
                        </div>
                        <div class="grid grid-cols-2 gap-2 p-3">
                            <div class="space-y-2">
                                <div class="rounded-2xl overflow-hidden h-40 md:h-48 bg-slate-900">
                                    <img src="https://images.pexels.com/photos/3738082/pexels-photo-3738082.jpeg?auto=compress&cs=tinysrgb&w=800"
                                        class="w-full h-full object-cover" alt="Batik Nusantara">
                                </div>
                                <div class="rounded-2xl overflow-hidden h-32 md:h-40 bg-slate-900">
                                    <img src="https://images.pexels.com/photos/3738085/pexels-photo-3738085.jpeg?auto=compress&cs=tinysrgb&w=800"
                                        class="w-full h-full object-cover" alt="Motif Batik">
                                </div>
                            </div>
                            <div class="space-y-2 mt-6">
                                <div class="rounded-2xl overflow-hidden h-32 md:h-40 bg-slate-900">
                                    <img src="https://images.pexels.com/photos/3951628/pexels-photo-3951628.jpeg?auto=compress&cs=tinysrgb&w=800"
                                        class="w-full h-full object-cover" alt="Pengrajin Batik">
                                </div>
                                <div class="rounded-2xl overflow-hidden h-40 md:h-48 bg-slate-900">
                                    <img src="https://images.pexels.com/photos/6594129/pexels-photo-6594129.jpeg?auto=compress&cs=tinysrgb&w=800"
                                        class="w-full h-full object-cover" alt="Batik Premium">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-6 -left-4 bg-white/90 dark:bg-slate-900/95 shadow-soft rounded-2xl px-4 py-3 flex items-center gap-3 border border-slate-200/60 dark:border-slate-700">
                        <div
                            class="h-8 w-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                            <i class="fa-solid fa-badge-check"></i>
                        </div>
                        <div class="text-xs">
                            <p class="font-semibold text-slate-800 dark:text-slate-100">Kualitas Terverifikasi</p>
                            <p class="text-slate-500 dark:text-slate-400">Langsung dari pengrajin terpercaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120"
                class="w-full h-12 text-gray-50 dark:text-slate-950 transition-colors duration-300">
                <path fill="currentColor"
                    d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,69.3C960,85,1056,107,1152,112C1248,117,1344,107,1392,101.3L1440,96L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    <!-- KEUNGGULAN / USP -->
    <section class="bg-white dark:bg-slate-950 py-12 border-b border-slate-100 dark:border-slate-900/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-6">
                <div class="col-span-2 md:col-span-1 flex flex-col justify-center">
                    <h2 class="text-2xl md:text-3xl font-display font-bold text-slate-900 dark:text-white mb-2">
                        Kenapa<br><span class="text-gradient">Batik Nusantara?</span>
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Kami menghadirkan batik berkualitas dengan harga UMKM, tanpa mengurangi rasa bangga saat
                        dikenakan.
                    </p>
                </div>
                <div class="md:col-span-3 grid sm:grid-cols-3 gap-4">
                    <div
                        class="rounded-2xl border border-amber-100 dark:border-amber-900/40 bg-amber-50/70 dark:bg-amber-950/20 p-4 flex gap-3">
                        <div class="h-9 w-9 rounded-xl bg-amber-500 text-white flex items-center justify-center">
                            <i class="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-slate-900 dark:text-amber-100">Dukung Pengrajin Lokal</p>
                            <p class="text-slate-600 dark:text-amber-200/70 text-xs mt-1">
                                Setiap pembelian langsung membantu UMKM dan pengrajin batik di Indonesia.
                            </p>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl border border-slate-100 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-900/40 p-4 flex gap-3">
                        <div class="h-9 w-9 rounded-xl bg-slate-900 text-amber-300 flex items-center justify-center">
                            <i class="fa-solid fa-feather"></i>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-slate-900 dark:text-slate-100">Nyaman Dipakai</p>
                            <p class="text-slate-600 dark:text-slate-300/80 text-xs mt-1">
                                Bahan adem & ringan, cocok untuk iklim tropis Indonesia dan dipakai seharian.
                            </p>
                        </div>
                    </div>
                    <div
                        class="rounded-2xl border border-emerald-100 dark:border-emerald-900/40 bg-emerald-50/70 dark:bg-emerald-950/20 p-4 flex gap-3">
                        <div class="h-9 w-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <div class="text-sm">
                            <p class="font-semibold text-slate-900 dark:text-emerald-100">Motif Pilihan</p>
                            <p class="text-slate-600 dark:text-emerald-200/80 text-xs mt-1">
                                Motif klasik & modern yang mudah dipadukan dengan outfit favoritmu.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRODUK -->
    <section id="produk" class="py-20 bg-white dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-10">
                <div>
                    <p class="text-xs font-semibold tracking-[0.3em] uppercase text-amber-500 mb-2">Koleksi Terbaru</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-slate-900 dark:text-white font-display">
                        Pilihan Batik<br><span class="text-gradient">Untuk Setiap Momen</span>
                    </h2>
                    <p class="text-sm md:text-base text-slate-600 dark:text-slate-400 mt-3 max-w-xl">
                        Koleksi batik eksklusif dengan detail rapi dan warna tahan lama. Cocok untuk acara resmi,
                        santai, ataupun hadiah spesial.
                    </p>
                </div>
                <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        <span>Ready stock & siap kirim</span>
                    </div>
                </div>
            </div>

            @if (isset($produks) && $produks->count())
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-7">
                    @foreach ($produks as $produk)
                        <div class="product-card bg-white dark:bg-slate-900 rounded-2xl shadow-soft/40 dark:shadow-none border border-slate-100 dark:border-slate-800 overflow-hidden open-modal-button group"
                            data-id="{{ $produk->id }}" data-nama="{{ $produk->nama_produk }}"
                            data-harga="{{ $produk->harga }}" data-deskripsi="{{ $produk->deskripsi }}"
                            data-gambar="{{ asset('storage/' . $produk->gambar_produk) }}"
                            data-stok="{{ $produk->stok }}" data-motif="{{ $produk->motif_batik }}"
                            data-kain="{{ $produk->jenis_kain }}" data-ukuran="{{ $produk->ukuran }}">

                            <div class="relative overflow-hidden">
                                <img src="{{ asset('storage/' . $produk->gambar_produk) }}"
                                    alt="{{ $produk->nama_produk }}"
                                    class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">

                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-medium bg-black/60 text-amber-200 backdrop-blur">
                                        <i class="fa-solid fa-fire text-amber-300"></i>
                                        Terlaris
                                    </span>
                                    @if ($produk->stok <= 5 && $produk->stok > 0)
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-medium bg-red-500/90 text-white">
                                            Stok menipis ({{ $produk->stok }})
                                        </span>
                                    @endif
                                </div>

                                <div
                                    class="absolute bottom-3 left-3 right-3 flex justify-between items-center text-[11px] text-white">
                                    <span
                                        class="inline-flex items-center gap-1 bg-black/40 px-2 py-1 rounded-full backdrop-blur">
                                        <i class="fa-solid fa-feather-pointed"></i>
                                        {{ $produk->motif_batik ?? 'Motif Eksklusif' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 bg-black/40 px-2 py-1 rounded-full backdrop-blur">
                                        <i class="fa-solid fa-ruler-combined"></i>
                                        {{ $produk->ukuran ?? 'All Size' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5 flex flex-col h-full">
                                <h3
                                    class="text-base font-semibold text-slate-900 dark:text-white mb-1.5 line-clamp-1 group-hover:text-amber-500 transition-colors">
                                    {{ $produk->nama_produk }}
                                </h3>
                                <p
                                    class="text-xs text-slate-500 dark:text-slate-400 mb-4 h-10 overflow-hidden leading-relaxed">
                                    {{ Str::limit($produk->deskripsi, 70) }}
                                </p>

                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-lg font-bold text-primary-700 dark:text-amber-300">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-[11px] text-slate-400 dark:text-slate-500">
                                        Stok: <span
                                            class="font-semibold text-slate-700 dark:text-slate-200">{{ $produk->stok }}</span>
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 mt-auto">
                                    <button
                                        class="flex-1 inline-flex items-center justify-center gap-2 bg-slate-900 text-white dark:bg-amber-500 dark:text-slate-900 px-3 py-2.5 rounded-xl text-xs font-semibold hover:bg-slate-800 dark:hover:bg-amber-400 transition">
                                        <i class="fas fa-cart-plus text-[11px]"></i>
                                        Tambah ke Keranjang
                                    </button>
                                    <button
                                        class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-[11px] font-semibold text-slate-700 dark:text-slate-200 hover:border-amber-500 hover:text-amber-500 dark:hover:text-amber-300 transition bg-white dark:bg-slate-900/80">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="text-center py-12 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400 text-lg mb-2">
                        Belum ada produk yang tersedia saat ini.
                    </p>
                    <p class="text-xs text-slate-400">
                        Tenang, koleksi terbaru sedang disiapkan oleh pengrajin terbaik kami. ✨
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- TENTANG KAMI -->
    <section id="tentang"
        class="py-20 bg-slate-50 dark:bg-slate-900/60 border-t border-slate-200/60 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                <div>
                    <p class="text-xs font-semibold tracking-[0.3em] uppercase text-amber-500 mb-3">Tentang Kami</p>
                    <h2 class="text-3xl font-display font-bold text-slate-900 dark:text-white mb-4">
                        Menjaga Warisan, <span class="text-gradient">Mencipta Gaya Baru</span>
                    </h2>
                    <p class="text-sm md:text-base text-slate-600 dark:text-slate-300 mb-4">
                        Batik Nusantara lahir dari keinginan untuk mempertemukan <span class="font-semibold">warisan
                            budaya</span> dengan
                        <span class="font-semibold">gaya hidup modern</span>. Kami bekerja sama dengan pengrajin lokal
                        untuk menghadirkan batik berkualitas, dengan proses yang tetap menghargai nilai tradisi.
                    </p>
                    <p class="text-sm md:text-base text-slate-600 dark:text-slate-300 mb-5">
                        Setiap helai kain adalah cerita tentang daerah, motif, dan tangan-tangan terampil yang
                        mengerjakannya. Dengan berbelanja di sini, kamu ikut menjaga agar cerita itu terus hidup.
                    </p>

                    <div class="grid grid-cols-3 gap-4 text-xs md:text-sm">
                        <div
                            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-4">
                            <p class="font-bold text-slate-900 dark:text-white text-lg">+10</p>
                            <p class="text-slate-500 dark:text-slate-400 mt-1">Pengrajin batik yang bergabung</p>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-4">
                            <p class="font-bold text-slate-900 dark:text-white text-lg">+30</p>
                            <p class="text-slate-500 dark:text-slate-400 mt-1">Motif eksklusif pilihan</p>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-4">
                            <p class="font-bold text-slate-900 dark:text-white text-lg">+500</p>
                            <p class="text-slate-500 dark:text-slate-400 mt-1">Pelanggan dari berbagai kota</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div
                        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div
                                class="h-10 w-10 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center">
                                <i class="fa-solid fa-quote-left"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Apa kata pelanggan</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100">Testimoni Singkat
                                </p>
                            </div>
                        </div>
                        <p class="text-sm text-slate-600 dark:text-slate-300 italic">
                            &ldquo;Batiknya adem, jahitannya rapi banget. Dipakai ke kantor maupun acara resmi tetap
                            cocok. Seneng bisa belanja sambil dukung UMKM lokal.&rdquo;
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">— Rina, Jakarta</p>
                    </div>

                    <div
                        class="bg-gradient-to-r from-amber-500 to-primary-700 rounded-2xl p-5 text-white flex items-center justify-between gap-4">
                        <div class="text-sm">
                            <p class="font-semibold mb-1">Ingin Reseller / Beli Grosir?</p>
                            <p class="text-xs text-amber-100">
                                Hubungi kami untuk harga khusus toko, kantor, atau keperluan seragam komunitas.
                            </p>
                        </div>
                        <a href="#kontak"
                            class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full text-xs font-semibold transition">
                            <i class="fa-brands fa-whatsapp"></i>
                            Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTAK -->
    <section id="kontak" class="py-16 bg-slate-950 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-10">
                <div>
                    <p class="text-xs font-semibold tracking-[0.3em] uppercase text-amber-400 mb-3">Kontak</p>
                    <h2 class="text-3xl font-display font-bold mb-4">
                        Yuk, Ngobrol dengan Kami
                    </h2>
                    <p class="text-sm md:text-base text-slate-300 mb-6">
                        Punya pertanyaan soal ukuran, bahan, atau ingin pesan dalam jumlah banyak?
                        Tim kami siap membantu lewat WhatsApp maupun email.
                    </p>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3">
                            <div
                                class="h-9 w-9 rounded-full bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-100">WhatsApp</p>
                                <p class="text-slate-400">+62 812-xxxx-xxxx</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="h-9 w-9 rounded-full bg-sky-500/10 text-sky-400 flex items-center justify-center">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-100">Email</p>
                                <p class="text-slate-400">halo@batiknusantara.id</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div
                                class="h-9 w-9 rounded-full bg-amber-500/10 text-amber-400 flex items-center justify-center">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-100">Lokasi</p>
                                <p class="text-slate-400">Indonesia • UMKM Lokal</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 md:p-7 shadow-soft">
                    <h3 class="text-lg font-semibold mb-4">Kirim Pesan Cepat</h3>
                    <form action="#" method="POST" class="space-y-4 text-sm">
                        <div>
                            <label class="block text-slate-300 mb-1.5">Nama</label>
                            <input type="text"
                                class="w-full rounded-xl bg-slate-950 border border-slate-700 px-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500/60 focus:border-transparent"
                                placeholder="Nama lengkap kamu">
                        </div>
                        <div>
                            <label class="block text-slate-300 mb-1.5">Email / WhatsApp</label>
                            <input type="text"
                                class="w-full rounded-xl bg-slate-950 border border-slate-700 px-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500/60 focus:border-transparent"
                                placeholder="Email atau nomor WA aktif">
                        </div>
                        <div>
                            <label class="block text-slate-300 mb-1.5">Pesan</label>
                            <textarea
                                class="w-full rounded-xl bg-slate-950 border border-slate-700 px-3 py-2.5 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-amber-500/60 focus:border-transparent h-24"
                                placeholder="Tulis pertanyaan atau kebutuhan kamu"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-amber-500 text-slate-950 px-4 py-2.5 rounded-xl font-semibold hover:bg-amber-400 transition">
                            <i class="fa-solid fa-paper-plane text-sm"></i>
                            Kirim Pesan
                        </button>
                        <p class="text-[11px] text-slate-500 mt-2">
                            Respon biasanya dalam 1x24 jam di hari kerja.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-800 py-6">
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <p>&copy; 2025 Batik Nusantara. Warisan Budaya Indonesia.</p>
            <p class="text-slate-500">
                Dibuat dengan ❤️ untuk mendukung UMKM Indonesia.
            </p>
        </div>
    </footer>

    <!-- MODAL PRODUK -->
    <div id="product-modal-backdrop"
        class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-[99] hidden transition-opacity duration-300"></div>
    <div id="product-modal" class="fixed inset-0 flex items-center justify-center p-4 z-[100] hidden">
        <div
            class="bg-white dark:bg-slate-900 rounded-3xl shadow-soft w-full max-w-4xl max-h-[90vh] flex flex-col md:flex-row transform modal-enter overflow-hidden border border-slate-200 dark:border-slate-800">
            <button id="close-modal-button"
                class="absolute top-4 right-4 bg-white/90 dark:bg-slate-800/90 hover:bg-white dark:hover:bg-slate-700 text-slate-700 dark:text-slate-100 rounded-full w-10 h-10 flex items-center justify-center shadow-md transition z-10">
                <i class="fas fa-times text-sm"></i>
            </button>

            <div class="w-full md:w-1/2 h-64 md:h-auto bg-slate-100 dark:bg-slate-950">
                <img id="modal-image" src="" alt="Detail Produk" class="w-full h-full object-cover">
            </div>

            <div class="w-full md:w-1/2 p-7 md:p-8 flex flex-col overflow-y-auto">
                <h2 id="modal-title"
                    class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2 font-display">Nama Produk
                </h2>
                <p id="modal-price" class="text-2xl md:text-3xl font-bold text-primary-700 dark:text-amber-400 mb-4">
                    Rp 0</p>

                <div class="text-sm text-slate-600 dark:text-slate-200 mb-5 flex-grow">
                    <p id="modal-description">Deskripsi lengkap produk...</p>
                </div>

                <div
                    class="grid grid-cols-2 gap-4 text-xs mb-6 bg-slate-50 dark:bg-slate-900/70 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <div>
                        <span
                            class="text-[10px] font-bold text-amber-500 uppercase tracking-wider block mb-1">Motif</span>
                        <span id="modal-motif" class="text-slate-900 dark:text-slate-100 font-medium"></span>
                    </div>
                    <div>
                        <span
                            class="text-[10px] font-bold text-amber-500 uppercase tracking-wider block mb-1">Kain</span>
                        <span id="modal-kain" class="text-slate-900 dark:text-slate-100 font-medium"></span>
                    </div>
                    <div>
                        <span
                            class="text-[10px] font-bold text-amber-500 uppercase tracking-wider block mb-1">Ukuran</span>
                        <span id="modal-ukuran" class="text-slate-900 dark:text-slate-100 font-medium"></span>
                    </div>
                    <div>
                        <span
                            class="text-[10px] font-bold text-amber-500 uppercase tracking-wider block mb-1">Stok</span>
                        <span id="modal-stock" class="text-emerald-600 dark:text-emerald-400 font-bold"></span>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <div
                            class="flex items-center border border-slate-300 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900/60">
                            <button id="quantity-minus"
                                class="px-4 py-2.5 text-slate-600 dark:text-slate-200 hover:bg-slate-200/60 dark:hover:bg-slate-700 rounded-l-xl transition font-bold">-</button>
                            <input id="quantity-input" type="number" value="1" min="1"
                                class="w-16 text-center border-none bg-transparent focus:ring-0 font-semibold text-slate-800 dark:text-slate-100">
                            <button id="quantity-plus"
                                class="px-4 py-2.5 text-slate-600 dark:text-slate-200 hover:bg-slate-200/60 dark:hover:bg-slate-700 rounded-r-xl transition font-bold">+</button>
                        </div>
                        <button id="add-to-cart-button"
                            class="w-full sm:w-auto flex-grow bg-slate-900 hover:bg-slate-800 dark:bg-amber-500 dark:hover:bg-amber-400 text-white dark:text-slate-900 font-bold py-3 px-6 rounded-xl transition-all transform hover:-translate-y-0.5 shadow-soft">
                            <i class="fas fa-cart-plus mr-2"></i>
                            Tambah ke Keranjang
                        </button>
                    </div>
                    <div id="modal-message-box"
                        class="mt-3 text-center p-3 rounded-xl text-xs hidden font-medium transition-all"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const modalBackdrop = document.getElementById('product-modal-backdrop');
            const modal = document.getElementById('product-modal');
            const modalContent = modal.querySelector('.transform');
            const openModalButtons = document.querySelectorAll('.open-modal-button');
            const closeModalButton = document.getElementById('close-modal-button');

            const modalImage = document.getElementById('modal-image');
            const modalTitle = document.getElementById('modal-title');
            const modalPrice = document.getElementById('modal-price');
            const modalDescription = document.getElementById('modal-description');
            const modalStock = document.getElementById('modal-stock');
            const modalMotif = document.getElementById('modal-motif');
            const modalKain = document.getElementById('modal-kain');
            const modalUkuran = document.getElementById('modal-ukuran');

            const addToCartButton = document.getElementById('add-to-cart-button');
            const quantityInput = document.getElementById('quantity-input');
            const quantityMinus = document.getElementById('quantity-minus');
            const quantityPlus = document.getElementById('quantity-plus');
            const messageBox = document.getElementById('modal-message-box');

            let currentProductId = null;
            let currentProductStock = 0;

            const addToCartUrl = "{{ route('keranjang.tambah') }}";
            const loginUrl = "{{ route('login') }}";

            const openModal = (data) => {
                modalImage.src = data.gambar;
                modalTitle.textContent = data.nama;
                modalPrice.textContent = `Rp ${parseInt(data.harga).toLocaleString('id-ID')}`;
                modalDescription.textContent = data.deskripsi;
                modalStock.textContent = `${data.stok} Tersisa`;
                modalMotif.textContent = data.motif;
                modalKain.textContent = data.kain;
                modalUkuran.textContent = data.ukuran;

                currentProductId = data.id;
                currentProductStock = parseInt(data.stok);

                quantityInput.max = currentProductStock;
                quantityInput.value = 1;
                messageBox.classList.add('hidden');

                modalBackdrop.classList.remove('hidden');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                requestAnimationFrame(() => {
                    modalBackdrop.style.opacity = '1';
                    modalContent.classList.add('modal-enter-active');
                    modalContent.classList.remove('modal-enter');
                });
            };

            const closeModal = () => {
                modalBackdrop.style.opacity = '0';
                modalContent.classList.add('modal-leave-active');
                modalContent.classList.remove('modal-enter-active');
                setTimeout(() => {
                    modalBackdrop.classList.add('hidden');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    modalContent.classList.remove('modal-leave-active');
                    modalContent.classList.add('modal-enter');
                }, 300);
            };

            const showMessage = (msg, isSuccess) => {
                messageBox.textContent = msg;
                messageBox.className = `mt-3 text-center p-3 rounded-lg text-xs font-medium transition-all ${
                    isSuccess
                        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300'
                        : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300'
                }`;
                messageBox.classList.remove('hidden');
            };

            openModalButtons.forEach(btn => {
                btn.addEventListener('click', () => openModal(btn.dataset));
            });

            closeModalButton.addEventListener('click', closeModal);
            modalBackdrop.addEventListener('click', closeModal);

            quantityMinus.addEventListener('click', () => {
                if (quantityInput.value > 1) quantityInput.value--;
            });
            quantityPlus.addEventListener('click', () => {
                if (parseInt(quantityInput.value) < currentProductStock) quantityInput.value++;
            });

            addToCartButton.addEventListener('click', async function() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const quantity = parseInt(quantityInput.value);

                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';

                try {
                    const response = await fetch(addToCartUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            produk_id: currentProductId,
                            kuantitas: quantity
                        })
                    });

                    if (response.status === 401) {
                        window.location.href = loginUrl;
                        return;
                    }

                    const result = await response.json();

                    if (!response.ok) throw new Error(result.message || 'Gagal menambahkan produk.');

                    showMessage('Berhasil masuk keranjang!', true);
                    setTimeout(closeModal, 1500);

                } catch (error) {
                    showMessage(error.message, false);
                } finally {
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang';
                }
            });
        });

        // Smooth scroll untuk anchor href="#..."
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href').substring(1);
                const target = document.getElementById(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
