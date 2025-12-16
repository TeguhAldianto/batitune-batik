<x-guest-layout>
    <div class="mb-6">
        <div class="flex justify-center mb-4">
            <i class="fas fa-store fa-3x text-indigo-600"></i>
        </div>
        <h2 class="text-2xl font-bold text-center text-slate-900 dark:text-slate-50">
            Masuk ke Aplikasi
        </h2>
        <p class="mt-2 text-sm text-center text-slate-600 dark:text-slate-300">
            Setiap Warna, Sebuah Kesabaran. Setiap Motif, Sebuah Doa </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5 mt-2">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')"
                class="text-sm font-medium text-slate-700 dark:text-slate-200" />

            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username"
                class="mt-1 w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="contoh: tokobatik@gmail.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')"
                    class="text-sm font-medium text-slate-700 dark:text-slate-200" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline hover:text-indigo-800"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa kata sandi?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                class="mt-1 w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Masukkan password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300">
                <input id="remember_me" type="checkbox"
                    class="rounded border-slate-300 dark:border-slate-600 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:ring-offset-0"
                    name="remember">
                <span>{{ __('Ingat saya di perangkat ini') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full inline-flex justify-center items-center rounded-xl bg-gradient-to-r from-brand to-orange-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-brand/30 hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Masuk Sekarang') }}
            </button>
        </div>

        <p class="text-xs text-center text-slate-600 dark:text-slate-300 mt-4">
            Belum punya akun?
            <a href="{{ route('register') }}"
                class="font-bold text-indigo-600 dark:text-indigo-400 hover:underline hover:text-indigo-800">
                Daftar disini
            </a>
        </p>
    </form>
</x-guest-layout>
