<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @forelse($pesanans as $pesanan)
                        <div class="mb-4 p-4 border rounded-md">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="font-bold">Kode Pesanan: {{ $pesanan->kode_pesanan }}</div>
                                    <div class="text-sm text-gray-600">Tanggal: {{ $pesanan->tanggal_pesanan->format('d M Y') }}</div>
                                    <div class="text-sm">Status: <span class="font-semibold capitalize">{{ str_replace('_', ' ', $pesanan->status_pesanan) }}</span></div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold">Total: Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</div>
                                    <a href="{{ route('pesanan.show', $pesanan) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Anda belum memiliki riwayat pesanan.</p>
                    @endforelse
                    
                    <div class="mt-4">
                        {{ $pesanans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>