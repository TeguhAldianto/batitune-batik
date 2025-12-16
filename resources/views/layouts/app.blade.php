<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UMKM Batik') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="antialiased font-['Inter'] bg-slate-100 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300">

    {{-- Background dekoratif --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        {{-- Mengubah gradient background menjadi nuansa ungu lembut --}}
        <div
            class="w-full h-full bg-gradient-to-br from-indigo-50 via-slate-100 to-purple-50 dark:from-slate-900 dark:via-slate-950 dark:to-slate-900">
        </div>
    </div>

    <div class="min-h-screen flex flex-col">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Hero / header opsional --}}
        @isset($header)
            <header class="relative overflow-hidden">
                {{-- Gradient Header Utama: Indigo -> Purple -> Pink --}}
                <div
                    class="absolute inset-0 bg-gradient-to-r from-brand via-orange-400 to-rose-400 dark:from-brand dark:via-orange-500 dark:to-emerald-500 opacity-90">
                </div>
                <div class="absolute inset-0 opacity-25 mix-blend-soft-light">
                    <div
                        class="w-full h-full bg-[radial-gradient(circle_at_top,_#ffffff_0,_transparent_55%),radial-gradient(circle_at_bottom,_#000000_0,_transparent_55%)]">
                    </div>
                </div>

                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
                    <div
                        class="bg-white/90 dark:bg-slate-900/80 backdrop-blur-md rounded-3xl shadow-xl border border-white/40 dark:border-white/10 px-6 py-5 md:px-8 md:py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="space-y-2">
                            <p class="text-xs uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-300">
                                Dashboard BATITUNE
                            </p>
                            <div
                                class="text-2xl md:text-3xl font-semibold text-slate-900 dark:text-slate-50 font-['Playfair Display']">
                                {{ $header }}
                            </div>
                            <p class="text-xs md:text-sm text-slate-600 dark:text-slate-300 max-w-xl">
                                Kelola produk, stok, dan transaksi batik dengan tampilan modern yang mudah digunakan
                                oleh pelaku UMKM di seluruh Indonesia.
                            </p>
                        </div>

                        <div class="flex flex-col items-end gap-2 text-right">
                            <span class="text-xs text-slate-600 dark:text-slate-300">
                                Hai, <span class="font-semibold">{{ Auth::user()->name ?? 'Pelaku UMKM' }}</span>
                            </span>
                            <span
                                class="inline-flex items-center rounded-full bg-slate-900 text-indigo-200 text-[11px] px-3 py-1 uppercase tracking-[0.18em] dark:bg-slate-800">
                                #BanggaBatikIndonesia
                            </span>
                        </div>
                    </div>
                </div>
            </header>
        @endisset

        {{-- Konten utama --}}
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-10">
                <div
                    class="bg-white/95 dark:bg-slate-900/90 rounded-3xl shadow-xl border border-slate-200/70 dark:border-slate-800/80 p-4 sm:p-6 md:p-8 backdrop-blur">
                    {{ $slot }}
                </div>
            </div>
        </main>

        {{-- Footer --}}
        @include('partials.footer')
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

        // tombol dengan id="theme-toggle" di navigation akan pakai ini
        document.addEventListener('click', (e) => {
            if (e.target.closest('#theme-toggle')) {
                const isDark = htmlEl.classList.contains('dark');
                setTheme(isDark ? 'light' : 'dark');
            }
        });
    </script>
</body>

</html>
