<x-landing-layout title="Keranjang Belanja - Batik Nusantara">
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-8 font-['Playfair Display']">Keranjang Belanja</h1>

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if (!$keranjang || $keranjang->itemKeranjangs->isEmpty())
                {{-- Tampilan Jika Keranjang Kosong --}}
                <div class="bg-white rounded-3xl shadow-sm p-12 text-center border border-indigo-50">
                    <div
                        class="mb-6 inline-flex items-center justify-center w-24 h-24 rounded-full bg-indigo-50 text-indigo-400">
                        <i class="fas fa-shopping-basket text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
                    <p class="text-gray-500 mb-8">Sepertinya Anda belum menambahkan batik pilihan ke keranjang.</p>
                    <a href="{{ route('produk.index') }}"
                        class="inline-flex items-center gap-2 bg-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                        <i class="fas fa-arrow-left"></i>
                        Mulai Belanja
                    </a>
                </div>
            @else
                <div class="flex flex-col lg:flex-row gap-8">
                    {{-- Daftar Item Keranjang --}}
                    <div class="w-full lg:w-2/3 space-y-4">
                        @foreach ($keranjang->itemKeranjangs as $item)
                            <div
                                class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row gap-6 items-center sm:items-start transition hover:shadow-md">
                                {{-- Gambar Produk --}}
                                <div
                                    class="w-24 h-24 sm:w-32 sm:h-32 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}"
                                        alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover">
                                </div>

                                {{-- Detail Produk --}}
                                <div class="flex-grow text-center sm:text-left">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $item->produk->nama_produk }}
                                    </h3>
                                    <p class="text-indigo-600 font-semibold mb-2">Rp
                                        {{ number_format($item->produk->harga, 0, ',', '.') }}</p>

                                    {{-- Stok Alert --}}
                                    @if ($item->produk->stok < $item->kuantitas)
                                        <p class="text-xs text-red-500 font-medium mb-2">
                                            <i class="fas fa-exclamation-circle"></i> Stok produk tersisa
                                            {{ $item->produk->stok }}
                                        </p>
                                    @endif

                                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 mt-4">
                                        {{-- Update Form (Quantity) --}}
                                        <form action="{{ route('keranjang.update', $item->id) }}" method="POST"
                                            class="flex items-center border border-gray-300 rounded-lg">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" name="kuantitas" value="{{ $item->kuantitas - 1 }}"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-l-lg transition">-</button>

                                            <input type="text" readonly value="{{ $item->kuantitas }}"
                                                class="w-10 text-center text-sm font-semibold border-none focus:ring-0 text-gray-800">

                                            <button type="submit" name="kuantitas" value="{{ $item->kuantitas + 1 }}"
                                                class="px-3 py-1 text-gray-600 hover:bg-gray-100 rounded-r-lg transition">+</button>
                                        </form>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-sm text-red-500 hover:text-red-700 font-medium flex items-center gap-1 transition"
                                                onclick="return confirm('Hapus item ini?')">
                                                <i class="fas fa-trash-alt"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Subtotal Item --}}
                                <div class="text-right hidden sm:block">
                                    <p class="text-sm text-gray-500 mb-1">Subtotal</p>
                                    <p class="text-lg font-bold text-gray-900">
                                        Rp {{ number_format($item->produk->harga * $item->kuantitas, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Ringkasan Belanja (Checkout) --}}
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Belanja</h3>

                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Total Item</span>
                                    <span>{{ $keranjang->itemKeranjangs->sum('kuantitas') }} Pcs</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Total Harga</span>
                                    @php
                                        $total = $keranjang->itemKeranjangs->sum(function ($item) {
                                            return $item->produk->harga * $item->kuantitas;
                                        });
                                    @endphp
                                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-dashed border-gray-200 my-4"></div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total Tagihan</span>
                                    <span class="text-xl font-bold text-indigo-600">Rp
                                        {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('pembayaran.checkout') }}"
                                class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3.5 rounded-xl font-bold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-500/30">
                                Lanjut ke Pembayaran
                            </a>

                            <p class="text-xs text-center text-gray-400 mt-4">
                                <i class="fas fa-lock"></i> Pembayaran Aman & Terenkripsi
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-landing-layout>
