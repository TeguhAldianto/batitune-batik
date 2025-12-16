<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Menggunakan Alpine.js untuk state management tab --}}
            <div x-data="{ activeTab: 'profile' }"
                class="bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl overflow-hidden border border-brand-50/50">

                {{-- Navigasi Tab --}}
                <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                    <nav class="-mb-px flex space-x-1 sm:space-x-4 px-4" aria-label="Tabs">
                        {{-- Tab 1: Profile --}}
                        <button @click="activeTab = 'profile'"
                            :class="{
                                'border-brand-500 text-brand-600 dark:text-brand-400 dark:border-brand-400 bg-white dark:bg-gray-800': activeTab === 'profile',
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200': activeTab !== 'profile'
                            }"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out focus:outline-none rounded-t-lg">
                            <i class="fas fa-user mr-2"></i> Informasi Profil
                        </button>

                        {{-- Tab 2: Password --}}
                        <button @click="activeTab = 'password'"
                            :class="{
                                'border-brand-500 text-brand-600 dark:text-brand-400 dark:border-brand-400 bg-white dark:bg-gray-800': activeTab === 'password',
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200': activeTab !== 'password'
                            }"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out focus:outline-none rounded-t-lg">
                            <i class="fas fa-key mr-2"></i> Ubah Kata Sandi
                        </button>

                        {{-- Tab 3: Delete --}}
                        <button @click="activeTab = 'delete'"
                            :class="{
                                'border-red-500 text-red-600 dark:text-red-500 dark:border-red-500 bg-white dark:bg-gray-800': activeTab === 'delete',
                                'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-200': activeTab !== 'delete'
                            }"
                            class="whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm transition-all duration-200 ease-in-out focus:outline-none rounded-t-lg">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus Akun
                        </button>
                    </nav>
                </div>

                {{-- Konten Panel Tab --}}
                <div class="p-6 sm:p-8">
                    {{-- Panel 1: Update Profile Information --}}
                    <div x-show="activeTab === 'profile'" class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- Panel 2: Update Password --}}
                    <div x-show="activeTab === 'password'" class="max-w-xl" style="display: none;">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Panel 3: Delete User --}}
                    <div x-show="activeTab === 'delete'" class="max-w-xl" style="display: none;">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
