{{-- Bagian Produk Terkait --}}
@isset($produk_terkait)
    @if($produk_terkait->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Anda Mungkin Juga Suka</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                
                @foreach ($produk_terkait as $item)
                    <div class="group relative bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl hover:shadow-slate-300 dark:hover:shadow-indigo-500/20 border border-slate-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 ease-in-out hover:-translate-y-2">
                        <div class="relative overflow-hidden">
                            <a href="{{ route('produk.show', $item) }}">
                                <img src="{{ asset('storage/' . $item->gambar_produk) }}" alt="{{ $item->nama_produk }}" class="h-64 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </a>
                            <div class="absolute top-3 left-3 bg-indigo-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $item->kategoriProduk->nama_kategori }}
                            </div>
                        </div>
                        <div class="p-5 flex flex-col">
                            <div class="flex-grow">
                                <a href="{{ route('produk.show', $item) }}">
                                    <h3 class="text-lg font-semibold text-slate-800 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $item->nama_produk }}
                                    </h3>
                                </a>
                                <p class="text-slate-700 dark:text-gray-300 mt-2 font-bold text-xl">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('produk.show', $item) }}" class="w-full text-center inline-block bg-slate-100 dark:bg-red-700 text-slate-700 dark:text-gray-200 py-2 px-4 rounded-lg font-medium hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-500 transition-colors duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endisset