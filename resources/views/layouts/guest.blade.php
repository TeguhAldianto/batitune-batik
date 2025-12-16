<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UMKM Batik') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased font-['Inter'] bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">

    {{-- Background Gradient Ungu Halus --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        <div
            class="w-full h-full bg-gradient-to-br from-indigo-50 via-slate-100 to-purple-100 dark:from-slate-900 dark:via-slate-950 dark:to-slate-900">
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-8">
        <div
            class="max-w-5xl w-full grid grid-cols-1 lg:grid-cols-2 rounded-3xl border border-white/40 dark:border-slate-800 bg-white/90 dark:bg-slate-950/80 shadow-[0_24px_60px_rgba(15,23,42,0.9)] overflow-hidden backdrop-blur-xl">

            {{-- Kiri: Hero Batik (Nuansa Gelap Elegan) --}}
            <div class="relative hidden lg:flex items-center justify-center bg-slate-950">
                <div class="absolute inset-0">
                    {{-- Gradient radial ungu --}}
                    <div
                        class="w-full h-full bg-[radial-gradient(circle_at_top,_#6366f1_0,_transparent_55%),radial-gradient(circle_at_bottom,_#0f172a_0,_transparent_60%)] opacity-60">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-950/95 to-slate-900/90">
                    </div>
                </div>

                <div class="relative z-10 px-10 py-12 space-y-6">
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-indigo-400/30 bg-indigo-900/30 px-4 py-1 text-[11px] uppercase tracking-[0.24em] text-indigo-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                        Platform BATITUNE
                    </span>

                    <h1 class="font-['Playfair Display'] text-3xl leading-tight text-slate-100">
                        Bawa <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">keluarga
                            anda menggunakan batik
                            Tulis</span>Lasem<br>
                    </h1>


                    <p class="text-sm text-slate-400 max-w-md">
                        Batik Tulis Lasem: Ketika Waktu Menjadi Karya Sejarah.
                    </p>

                    <div class="flex items-center gap-4 pt-2">
                        <div class="flex -space-x-2">
                            <div class="h-8 w-8 rounded-full border border-slate-800 bg-indigo-500/80"></div>
                            <div class="h-8 w-8 rounded-full border border-slate-800 bg-purple-500/80"></div>
                            <div class="h-8 w-8 rounded-full border border-slate-800 bg-pink-500/80"></div>
                        </div>
                        <div class="text-[11px] text-slate-400">
                            Dipercaya pelaku Pelanggan Setia batik<br>
                            di berbagai daerah di Indonesia.
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <div class="h-px w-full bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent">
                        </div>
                        <p class="text-[11px] uppercase tracking-[0.30em] text-indigo-200/60">
                            #BanggaBatikIndonesia
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kanan: Card form auth --}}
            <div class="px-6 py-8 sm:px-8 sm:py-10 bg-white/95 dark:bg-slate-950/90">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div
                            class="h-10 w-10 rounded-2xl bg-gradient-to-br from-brand to-orange-600 flex items-center justify-center shadow-md shadow-brand/40">
                            <span class="text-white font-bold text-lg">B</span>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.22em] text-indigo-600 dark:text-indigo-400">
                                UMKM Batik
                            </p>
                            <p class="text-sm text-slate-600 dark:text-slate-200">
                                {{ config('app.name', 'Dashboard Batik') }}
                            </p>
                        </div>
                    </div>

                    <button id="theme-toggle"
                        class="inline-flex items-center rounded-full border border-slate-200 dark:border-slate-700 px-2.5 py-1 text-[11px] text-slate-700 dark:text-slate-200 bg-white/70 dark:bg-slate-900/80 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                        <span class="mr-1">Tema</span>
                        <span class="text-xs">🌓</span>
                    </button>
                </div>

                <div class="space-y-6">
                    {{ $slot }}
                </div>

                <p class="mt-8 text-[11px] text-center text-slate-500 dark:text-slate-400">
                    © {{ date('Y') }} Platform UMKM Batik Indonesia.
                    <span class="hidden sm:inline">Mendukung pengrajin &amp; pelaku UMKM di seluruh Nusantara.</span>
                </p>
            </div>
        </div>
    </div>

    <script>
        const htmlEl = document.documentElement;

        function setTheme(theme) {
            if (theme === 'dark') {
                htmlEl.classList.add('dark');
            } else {
                htmlEl.classList.remove('dark');
            }
            localStorage.setItem('theme', theme);
        }

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            setTheme(savedTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            setTheme('dark');
        } else {
            setTheme('light');
        }

        document.addEventListener('click', (e) => {
            if (e.target.closest('#theme-toggle')) {
                const isDark = htmlEl.classList.contains('dark');
                setTheme(isDark ? 'light' : 'dark');
            }
        });
    </script>

    @include('partials.footer')
</body>

</html>
