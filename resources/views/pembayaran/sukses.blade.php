<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Batik Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .text-gradient {
            background: linear-gradient(135deg, #4f46e5, #9333ea, #db2777);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes success-check {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-check {
            animation: success-check 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">

    <nav class="bg-white/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-gradient font-['Playfair Display']">Batik
                        Nusantara</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6 shadow-lg shadow-green-500/20 animate-check">
                    <svg class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2 font-['Playfair Display']">Pembayaran Berhasil!</h1>
                <p class="text-gray-500 text-lg">Pesanan Anda telah dikonfirmasi.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-indigo-50">
                <div class="h-2 bg-gradient-to-r from-brand via-orange-400 to-rose-400"></div>

                <div class="p-8">
                    <div class="border-b border-gray-100 pb-6 mb-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <p class="text-xs font-bold text-indigo-500 tracking-widest uppercase mb-1">Nomor
                                    Pesanan</p>
                                <p class="text-3xl font-bold text-gray-900 font-mono tracking-tight">
                                    {{ $pesanan->kode_pesanan }}</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <p class="text-xs font-bold text-gray-400 tracking-widest uppercase mb-1">Tanggal</p>
                                <p class="text-lg font-medium text-gray-700">
                                    {{ $pesanan->tanggal_pesanan->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i> Pengiriman
                            </h3>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <p class="font-bold text-gray-900">{{ $pesanan->alamatPengiriman->nama_penerima }}</p>
                                <p class="text-gray-600 text-sm mt-1 leading-relaxed">
                                    {{ $pesanan->alamatPengiriman->alamat_lengkap }}<br>
                                    {{ $pesanan->alamatPengiriman->kota }}, {{ $pesanan->alamatPengiriman->provinsi }}
                                    {{ $pesanan->alamatPengiriman->kode_pos }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3 flex items-center">
                                <i class="fas fa-info-circle text-indigo-500 mr-2"></i> Status
                            </h3>
                            <div class="space-y-2">
                                <div
                                    class="flex justify-between items-center p-3 bg-green-50 rounded-xl border border-green-100">
                                    <span class="text-sm font-medium text-green-800">Pembayaran</span>
                                    <span
                                        class="px-2 py-1 bg-green-200 text-green-800 text-xs rounded-lg font-bold uppercase">Sukses</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 bg-indigo-50 rounded-xl border border-indigo-100">
                                    <span class="text-sm font-medium text-indigo-800">Pesanan</span>
                                    <span
                                        class="px-2 py-1 bg-indigo-200 text-indigo-800 text-xs rounded-lg font-bold uppercase">Diproses</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-indigo-600 mb-1">Total Pembayaran</p>
                            <p class="text-xs text-gray-500">Termasuk ongkos kirim</p>
                        </div>
                        <p class="text-3xl font-bold text-indigo-900">Rp
                            {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                <a href="{{ route('pesanan.index') }}"
                    class="flex items-center justify-center px-6 py-4 bg-white border-2 border-indigo-100 text-indigo-600 font-bold rounded-xl hover:bg-indigo-50 hover:border-indigo-200 transition-all duration-300">
                    <i class="fas fa-box-open mr-2"></i> Cek Pesanan Saya
                </a>
                <a href="/"
                    class="flex items-center justify-center px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 shadow-lg shadow-indigo-500/30 transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-shopping-bag mr-2"></i> Belanja Lagi
                </a>
            </div>
        </div>
    </div>
</body>

</html>
