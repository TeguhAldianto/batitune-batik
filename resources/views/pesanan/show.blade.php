<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan: {{ $pesanan->kode_pesanan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Item yang Dipesan</h3>
                @foreach($pesanan->detailPesanans as $item)
                    <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b' : '' }}">
                        <div>
                            <p class="font-semibold">{{ $item->nama_produk_saat_pesan }}</p>
                            <p class="text-sm text-gray-600">{{ $item->kuantitas }} x Rp {{ number_format($item->harga_produk_saat_pesan, 0, ',', '.') }}</p>
                        </div>
                        <p class="font-semibold">Rp {{ number_format($item->subtotal_item, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>

            @if($pesanan->status_pesanan == 'selesai')
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Beri Ulasan</h3>
                <form action="{{ route('ulasan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
                    
                    <div class="mb-4">
                        <label for="produk_id" class="block font-medium text-sm text-gray-700">Pilih Produk</label>
                        <select name="produk_id" id="produk_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach($pesanan->detailPesanans as $item)
                                <option value="{{ $item->produk_id }}">{{ $item->nama_produk_saat_pesan }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="rating" class="block font-medium text-sm text-gray-700">Rating (1-5)</label>
                        <input type="number" name="rating" id="rating" min="1" max="5" required class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div class="mb-4">
                        <label for="komentar" class="block font-medium text-sm text-gray-700">Komentar (Opsional)</label>
                        <textarea name="komentar" id="komentar" rows="3" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>

                    <x-primary-button>
                        Kirim Ulasan
                    </x-primary-button>
                </form>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Detail Pengiriman</h3>
                    <p class="font-semibold">{{ $pesanan->alamatPengiriman->nama_penerima }}</p>
                    <p class="text-sm">{{ $pesanan->alamatPengiriman->no_hp_penerima }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ $pesanan->alamatPengiriman->alamat_lengkap }}, {{ $pesanan->alamatPengiriman->kota }}, {{ $pesanan->alamatPengiriman->provinsi }} {{ $pesanan->alamatPengiriman->kode_pos }}</p>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold border-b pb-2 mb-4">Ringkasan Biaya</h3>
                    <div class="flex justify-between text-sm"><p>Subtotal Produk:</p> <p>Rp {{ number_format($pesanan->total_harga_produk, 0, ',', '.') }}</p></div>
                    <div class="flex justify-between text-sm"><p>Biaya Pengiriman:</p> <p>Rp {{ number_format($pesanan->biaya_pengiriman, 0, ',', '.') }}</p></div>
                    <div class="flex justify-between text-sm font-bold mt-2 pt-2 border-t"><p>Total Keseluruhan:</p> <p>Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</p></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>