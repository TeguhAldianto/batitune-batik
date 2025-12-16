<x-app-layout>
    <div class="bg-slate-50 dark:bg-gray-900">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Koleksi Produk Kami') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Grid Produk --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse($produks as $produk)
                        <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl hover:shadow-slate-300 dark:hover:shadow-indigo-500/20 border border-slate-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 ease-in-out hover:-translate-y-2">
                            
                            {{-- Gambar dan Badge Kategori --}}
                            <div class="relative overflow-hidden">
                                <a href="{{ route('produk.show', $produk) }}">
                                    <img src="{{ asset('storage/' . $produk->gambar_produk) }}" alt="{{ $produk->nama_produk }}" class="h-64 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </a>
                                <div class="absolute top-3 left-3 bg-indigo-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                    {{ $produk->kategoriProduk->nama_kategori }}
                                </div>
                            </div>
                            
                            {{-- Konten Kartu --}}
                            <div class="p-5 flex flex-col h-full">
                                <div class="flex-grow">
                                    <a href="{{ route('produk.show', $produk) }}">
                                        <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $produk->nama_produk }}
                                        </h3>
                                    </a>
                                    <p class="text-slate-700 dark:text-gray-300 mt-2 font-bold text-xl">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('produk.show', $produk) }}" class="w-full text-center inline-block bg-slate-100 dark:bg-gray-700 text-slate-700 dark:text-gray-200 py-2 px-4 rounded-lg font-medium hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-500 transition-colors duration-300">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white dark:bg-gray-800 rounded-lg p-12 text-center border border-dashed border-slate-300 dark:border-gray-700">
                             <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                             </svg>
                            <h3 class="mt-2 text-sm font-medium text-slate-900 dark:text-gray-100">Koleksi Masih Kosong</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-gray-400">Belum ada produk untuk ditampilkan. Silakan cek kembali nanti.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Link Paginasi --}}
                <div class="mt-12">
                    {{ $produks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>