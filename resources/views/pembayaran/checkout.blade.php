<x-landing-layout title="Checkout - Batik Nusantara">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 font-['Playfair Display']">Checkout Pesanan</h1>
                <p class="text-gray-500 mt-2">Selesaikan pembayaran untuk memiliki batik pilihan Anda.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <div class="w-full lg:w-2/3 space-y-6">

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-indigo-600"></i> Alamat Pengiriman
                            </h2>
                            <a href="{{ route('alamat.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                + Kelola Alamat
                            </a>
                        </div>

                        @if($alamats->isEmpty())
                            <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-6 text-center">
                                <p class="text-indigo-800 mb-3 font-medium">Anda belum memiliki alamat pengiriman.</p>
                                <a href="{{ route('alamat.index') }}" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 transition shadow-md shadow-indigo-500/20">
                                    Tambah Alamat Baru
                                </a>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($alamats as $alamat)
                                <label class="relative flex items-start p-4 border rounded-xl cursor-pointer transition-all duration-200
                                    {{ $loop->first ? 'border-indigo-500 ring-1 ring-indigo-500 bg-indigo-50/30' : 'border-gray-200 hover:border-indigo-300 hover:bg-gray-50' }}">
                                    <div class="flex items-center h-5">
                                        <input type="radio" name="alamat_pengiriman_id" value="{{ $alamat->id }}"
                                               class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" {{ $loop->first ? 'checked' : '' }}>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900">{{ $alamat->nama_penerima }} <span class="text-gray-500 font-normal ml-1 bg-gray-100 px-2 py-0.5 rounded text-xs">{{ $alamat->label_alamat }}</span></span>
                                        <span class="block text-gray-600 mt-0.5">{{ $alamat->no_hp_penerima }}</span>
                                        <span class="block text-gray-500 mt-1">{{ $alamat->alamat_lengkap }}, {{ $alamat->kota }}, {{ $alamat->provinsi }} {{ $alamat->kode_pos }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-shopping-bag text-indigo-600"></i> Rincian Pesanan
                        </h2>
                        <div class="divide-y divide-gray-100">
                            @foreach($keranjang->itemKeranjangs as $item)
                            <div class="py-4 flex gap-4">
                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-50">
                                    <img src="{{ asset('storage/' . $item->produk->gambar_produk) }}" alt="{{ $item->produk->nama_produk }}" class="h-full w-full object-cover object-center">
                                </div>
                                <div class="flex flex-1 flex-col justify-center">
                                    <div>
                                        <div class="flex justify-between text-base font-bold text-gray-900">
                                            <h3>{{ $item->produk->nama_produk }}</h3>
                                            <p class="ml-4 text-indigo-600">Rp {{ number_format($item->produk->harga * $item->kuantitas, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">{{ $item->produk->jenis_kain }} &bull; {{ $item->produk->motif_batik }}</p>
                                    </div>
                                    <div class="flex flex-1 items-end justify-between text-sm mt-2">
                                        <p class="text-gray-500 font-medium bg-gray-100 px-2 py-1 rounded-lg">Qty: {{ $item->kuantitas }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-2xl shadow-lg border border-indigo-50 p-6 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100">Ringkasan Pembayaran</h2>

                        <div class="space-y-4">
                            <div class="flex justify-between text-sm text-gray-600">
                                <p>Total Harga Produk</p>
                                @php
                                    $totalProduk = $keranjang->itemKeranjangs->sum(function($item) {
                                        return $item->produk->harga * $item->kuantitas;
                                    });
                                    $biayaPengiriman = 15000;
                                    $totalBayar = $totalProduk + $biayaPengiriman;
                                @endphp
                                <p class="font-medium">Rp {{ number_format($totalProduk, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <p>Biaya Pengiriman</p>
                                <p class="font-medium">Rp {{ number_format($biayaPengiriman, 0, ',', '.') }}</p>
                            </div>

                            <div class="border-t border-dashed border-gray-200 pt-4 mt-4">
                                <div class="flex justify-between items-center">
                                    <p class="text-base font-bold text-gray-900">Total Tagihan</p>
                                    <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <button id="pay-button" class="w-full mt-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 rounded-xl font-bold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-500/30 flex justify-center items-center gap-2 transform hover:-translate-y-0.5" {{ $alamats->isEmpty() ? 'disabled' : '' }}>
                            <i class="fas fa-lock"></i> Bayar Sekarang
                        </button>

                        @if($alamats->isEmpty())
                            <p class="text-xs text-red-500 text-center mt-3 font-medium bg-red-50 py-2 rounded-lg">Mohon tambah alamat pengiriman terlebih dahulu.</p>
                        @endif

                        <div id="loading-message" class="hidden mt-4 text-center bg-gray-50 py-2 rounded-lg">
                            <span class="text-sm text-gray-500 flex items-center justify-center gap-2">
                                <i class="fas fa-circle-notch fa-spin text-indigo-600"></i> Sedang memproses...
                            </span>
                        </div>

                        <p class="text-[10px] text-center text-gray-400 mt-4 flex items-center justify-center gap-1">
                            <i class="fas fa-shield-alt"></i> Pembayaran Aman & Terenkripsi
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const payButton = document.getElementById('pay-button');
        const loadingMessage = document.getElementById('loading-message');

        // [FIX] Menggunakan route yang benar 'pembayaran.proses'
        const processUrl = "{{ route('pembayaran.proses') }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        payButton.addEventListener('click', async function() {
            const selectedAddress = document.querySelector('input[name="alamat_pengiriman_id"]:checked');

            if (!selectedAddress) {
                alert('Silakan pilih alamat pengiriman terlebih dahulu.');
                return;
            }

            payButton.disabled = true;
            payButton.classList.add('opacity-75', 'cursor-not-allowed');
            loadingMessage.classList.remove('hidden');

            try {
                const response = await fetch(processUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        alamat_pengiriman_id: selectedAddress.value
                    })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.error || 'Terjadi kesalahan saat memproses pesanan.');
                }

                window.snap.pay(result.snap_token, {
                    onSuccess: function(result){
                        window.location.href = "/pesanan/sukses/" + result.order_id;
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran Anda!");
                        window.location.href = "/pesanan";
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                        location.reload();
                    },
                    onClose: function(){
                        alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                        payButton.disabled = false;
                        payButton.classList.remove('opacity-75', 'cursor-not-allowed');
                        loadingMessage.classList.add('hidden');
                    }
                });

            } catch (error) {
                console.error(error);
                alert(error.message);
                payButton.disabled = false;
                payButton.classList.remove('opacity-75', 'cursor-not-allowed');
                loadingMessage.classList.add('hidden');
            }
        });
    </script>
</x-landing-layout>
