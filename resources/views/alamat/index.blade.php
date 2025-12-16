<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kelola Alamat Pengiriman') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-xl border border-green-200 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center"><i class="fas fa-map-marked-alt"></i></div>
                        Daftar Alamat
                    </h3>

                    @forelse($alamats as $alamat)
                        <div class="bg-white dark:bg-gray-800 p-6 shadow-sm rounded-2xl border transition-all duration-300 hover:shadow-md
                            {{ $alamat->is_alamat_utama ? 'border-indigo-500 ring-1 ring-indigo-500/50 bg-indigo-50/5' : 'border-gray-100 dark:border-gray-700' }}">

                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="font-bold text-gray-900 dark:text-white text-lg">{{ $alamat->label_alamat }}</span>
                                        @if($alamat->is_alamat_utama)
                                            <span class="bg-indigo-600 text-white text-[10px] uppercase font-bold px-2 py-0.5 rounded">Utama</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-900 dark:text-gray-200 font-medium">{{ $alamat->nama_penerima }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $alamat->no_hp_penerima }}</p>
                                    <div class="mt-3 text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded-xl border border-gray-200 dark:border-gray-600">
                                        {{ $alamat->alamat_lengkap }}<br>
                                        {{ $alamat->kota }}, {{ $alamat->provinsi }} {{ $alamat->kode_pos }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-700 flex gap-4">
                                @if(!$alamat->is_alamat_utama)
                                    <form action="{{ route('alamat.set-utama', $alamat) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">
                                            Jadikan Utama
                                        </button>
                                    </form>
                                    <div class="w-px bg-gray-300"></div>
                                @endif
                                <form action="{{ route('alamat.destroy', $alamat) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 font-semibold hover:underline"
                                        onclick="return confirm('Hapus alamat ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white rounded-2xl border-2 border-dashed border-gray-200">
                            <i class="fas fa-map-signs text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500 font-medium">Belum ada alamat tersimpan.</p>
                        </div>
                    @endforelse
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-2xl border border-indigo-50 dark:border-gray-700 sticky top-24">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                            Tambah Alamat Baru
                        </h3>
                        <form action="{{ route('alamat.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <x-input-label for="label_alamat" value="Label (Rumah, Kantor)" />
                                <x-text-input id="label_alamat" name="label_alamat" type="text" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Rumah" required />
                            </div>
                            <div>
                                <x-input-label for="nama_penerima" value="Nama Penerima" />
                                <x-text-input id="nama_penerima" name="nama_penerima" type="text" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required />
                            </div>
                            <div>
                                <x-input-label for="no_hp_penerima" value="No. HP" />
                                <x-text-input id="no_hp_penerima" name="no_hp_penerima" type="tel" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required />
                            </div>
                            <div>
                                <x-input-label for="alamat_lengkap" value="Alamat Lengkap" />
                                <textarea id="alamat_lengkap" name="alamat_lengkap" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-600 dark:text-gray-300" rows="3" placeholder="Nama Jalan, No. Rumah, RT/RW" required></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="kota" value="Kota" />
                                    <x-text-input id="kota" name="kota" type="text" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required />
                                </div>
                                <div>
                                    <x-input-label for="kode_pos" value="Kode Pos" />
                                    <x-text-input id="kode_pos" name="kode_pos" type="text" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="provinsi" value="Provinsi" />
                                <x-text-input id="provinsi" name="provinsi" type="text" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required />
                            </div>

                            <button type="submit" class="w-full mt-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5">
                                Simpan Alamat
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
