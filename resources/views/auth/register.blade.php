<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-50">
            Daftar Akun Baru
        </h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
            Bergabunglah bersama kami
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name"
                class="block mt-1 w-full rounded-xl focus:border-indigo-500 focus:ring-indigo-500" type="text"
                name="name" :value="old('name')" required autofocus autocomplete="name"
                placeholder="Nama usaha atau pemilik" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email"
                class="block mt-1 w-full rounded-xl focus:border-indigo-500 focus:ring-indigo-500" type="email"
                name="email" :value="old('email')" required autocomplete="username" placeholder="alamat@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password"
                class="block mt-1 w-full rounded-xl focus:border-indigo-500 focus:ring-indigo-500" type="password"
                name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />

            <x-text-input id="password_confirmation"
                class="block mt-1 w-full rounded-xl focus:border-indigo-500 focus:ring-indigo-500" type="password"
                name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full inline-flex justify-center items-center rounded-xl bg-gradient-to-r from-brand to-orange-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-brand/30 hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>

        <div class="flex items-center justify-center mt-4">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Sudah punya akun?
                <a class="font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Masuk disini') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
