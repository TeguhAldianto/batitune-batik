<x-landing-layout title="Batik Negeri Lasem - Warisan Budaya Indonesia">
    {{-- header & footer sudah dari landing-layout --}}

    {{-- HERO --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-indigo-900 to-purple-800 text-white">
        <div class="absolute inset-0 opacity-25 bg-[url('/images/batik-pattern.svg')] bg-center bg-cover"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(251,191,36,0.20),_transparent_55%)]"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-28">
            <div class="grid md:grid-cols-2 gap-10 items-center">
                {{-- Text --}}
                <div class="space-y-6">
                    <div
                        class="inline-flex items-center gap-2 bg-black/30 border border-white/10 text-amber-200 px-4 py-1 rounded-full text-xs tracking-[0.25em] uppercase backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>BATITUNE • erta • Lasem</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        Batik Klasik,
                        <span class="text-amber-300">Gaya Masa Kini</span>
                    </h1>

                    <p class="text-base md:text-lg text-indigo-100/90 max-w-xl">
                        Temukan keindahan batik tradisional Indonesia dengan sentuhan modern. Nyaman dipakai,
                        elegan untuk kerja, pesta, maupun acara keluarga.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#produk"
                            class="inline-flex items-center gap-3 bg-amber-400 text-slate-900 px-8 py-3.5 rounded-full font-semibold text-sm md:text-base shadow-lg shadow-amber-500/30 hover:bg-amber-300 hover:-translate-y-0.5 transition-transform">
                            <i class="fas fa-shopping-bag"></i>
                            Jelajahi Koleksi
                        </a>
                        <a href="#tentang"
                            class="inline-flex items-center gap-3 border border-indigo-300/70 text-indigo-100 px-8 py-3.5 rounded-full font-semibold text-sm md:text-base hover:bg-white hover:text-slate-900 transition-transform hover:-translate-y-0.5 bg-white/5 backdrop-blur">
                            <i class="fas fa-info-circle"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-4 pt-2 text-xs md:text-sm">
                        <div>
                            <p class="text-2xl font-bold text-amber-300">+500</p>
                            <p class="text-indigo-100/80">Pelanggan dari berbagai kota</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-amber-300">100%</p>
                            <p class="text-indigo-100/80">Kain lembut & adem dipakai</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-amber-300">UMKM</p>
                            <p class="text-indigo-100/80">Dukungan untuk pengrajin lokal</p>
                        </div>
                    </div>
                </div>

                {{-- Visual --}}
                <div class="relative hidden md:block">
                    <div
                        class="absolute -inset-4 bg-gradient-to-tr from-amber-500/30 via-purple-500/20 to-indigo-500/30 rounded-3xl blur-2xl">
                    </div>
                    <div
                        class="relative rounded-3xl bg-slate-900/50 border border-white/10 shadow-2xl overflow-hidden backdrop-blur">
                        <div class="grid grid-cols-2 gap-2 p-3">
                            <div class="space-y-2">
                                <div class="rounded-2xl overflow-hidden h-40 bg-slate-900">
                                    <img src="{{ asset('storage/img/1.jpg') }}" alt="Batik Negeri Lasem"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="rounded-2xl overflow-hidden h-32 bg-slate-900">
                                    <img src="{{ asset('storage/img/2.jpg') }}" alt="Motif Batik"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="space-y-2 mt-6">
                                <div class="rounded-2xl overflow-hidden h-32 bg-slate-900">
                                    <img src="{{ asset('storage/img/3.jpg') }}" alt="Pengrajin Batik"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="rounded-2xl overflow-hidden h-40 bg-slate-900">
                                    <img src="{{ asset('storage/img/canting2.jpg') }}" alt="Detail Batik"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-5 left-4 right-4 bg-black/50 border border-white/5 rounded-2xl p-3 flex items-center gap-3 text-xs text-indigo-50 backdrop-blur">
                            <div
                                class="h-8 w-8 rounded-full bg-emerald-500/20 text-emerald-300 flex items-center justify-center">
                                <i class="fas fa-badge-check"></i>
                            </div>
                            <div>
                                <p class="font-semibold leading-tight">Kualitas Terkurasi</p>
                                <p class="text-[11px] text-indigo-100/80">Dipilih langsung dari pengrajin batik
                                    terpercaya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" class="w-full h-12 text-white/95">
                <path fill="currentColor"
                    d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,69.3C960,85,1056,107,1152,112C1248,117,1344,107,1392,101.3L1440,96L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z">
                </path>
            </svg>
        </div>
    </section>

    {{-- USP STRIP --}}
    <section class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Dukung Pengrajin Lokal</p>
                        <p class="text-gray-500 text-xs">Setiap pembelian ikut menghidupkan UMKM Indonesia.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center">
                        <i class="fas fa-feather"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Bahan Nyaman & Adem</p>
                        <p class="text-gray-500 text-xs">Cocok untuk iklim tropis & dipakai seharian.</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center">
                        <i class="fas fa-award"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Motif Kurasi Khusus</p>
                        <p class="text-gray-500 text-xs">Perpaduan motif klasik dan modern yang mudah di-mix & match.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PRODUK --}}
    <section id="produk" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-12">
                <div>
                    <p class="text-xs font-semibold tracking-[0.3em] text-indigo-500 uppercase mb-2">Koleksi Terbaru</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                        Pilihan Batik
                        <span
                            class="bg-gradient-to-r from-indigo-600 via-purple-600 to-amber-500 bg-clip-text text-transparent">
                            Untuk Setiap Momen
                        </span>
                    </h2>
                    <p class="text-gray-600 text-sm md:text-base mt-3 max-w-xl">
                        Dari acara kasual sampai formal, temukan batik yang pas dengan gaya dan kepribadianmu.
                    </p>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-gray-200">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Ready stock & siap kirim
                    </span>
                </div>
            </div>

            @if (isset($produks) && $produks->count())
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($produks as $produk)
                        <div class="product-card bg-white rounded-2xl overflow-hidden open-modal-button transform transition hover:-translate-y-2 hover:shadow-2xl border border-gray-100 group cursor-pointer"
                            data-id="{{ $produk->id }}" data-nama="{{ $produk->nama_produk }}"
                            data-harga="{{ $produk->harga }}" data-deskripsi="{{ $produk->deskripsi }}"
                            data-gambar="{{ asset('storage/' . $produk->gambar_produk) }}"
                            data-stok="{{ $produk->stok }}" data-motif="{{ $produk->motif_batik }}"
                            data-kain="{{ $produk->jenis_kain }}" data-ukuran="{{ $produk->ukuran }}">

                            <div class="relative">
                                <img src="{{ asset('storage/' . $produk->gambar_produk) }}" loading="lazy"
                                    decoding="async" alt="{{ $produk->nama_produk }}"
                                    class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105">

                                {{-- Badge stok --}}
                                @if ($produk->stok <= 0)
                                    <span
                                        class="absolute top-3 left-3 bg-gray-900 text-white text-[11px] px-2.5 py-1 rounded-full font-semibold shadow">
                                        Habis
                                    </span>
                                @elseif($produk->stok <= 5)
                                    <span
                                        class="absolute top-3 left-3 bg-red-500 text-white text-[11px] px-2.5 py-1 rounded-full font-semibold shadow">
                                        Stok Terbatas ({{ $produk->stok }})
                                    </span>
                                @else
                                    <span
                                        class="absolute top-3 left-3 bg-white/90 text-indigo-900 text-[11px] px-2.5 py-1 rounded-full font-medium shadow">
                                        Stok: {{ $produk->stok }}
                                    </span>
                                @endif

                                {{-- Info kecil di bawah gambar --}}
                                <div
                                    class="absolute bottom-3 left-3 right-3 flex justify-between text-[11px] text-white">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-black/45 backdrop-blur">
                                        <i class="fas fa-feather text-amber-300"></i>
                                        {{ $produk->motif_batik ?? 'Motif Eksklusif' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-black/45 backdrop-blur">
                                        <i class="fas fa-ruler-combined"></i>
                                        {{ $produk->ukuran ?? 'All Size' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 flex flex-col h-full">
                                <h3
                                    class="text-base font-semibold text-gray-900 mb-1 truncate group-hover:text-indigo-600 transition-colors">
                                    {{ $produk->nama_produk }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4 h-10 overflow-hidden">
                                    {{ Str::limit($produk->deskripsi, 70) }}
                                </p>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-lg font-bold text-indigo-700">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="text-xs text-gray-400">Klik untuk lihat detail</span>
                                </div>

                                <div class="mt-auto flex items-center gap-2">
                                    <button
                                        class="flex-1 inline-flex items-center justify-center gap-2 px-3 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700 transition">
                                        <i class="fas fa-cart-plus text-[11px]"></i>
                                        Tambah ke Keranjang
                                    </button>
                                    <button
                                        class="px-3 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-700 hover:border-indigo-500 hover:text-indigo-600 bg-white transition">
                                        Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-gray-200">
                    <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-700 text-lg mb-1">Saat ini belum ada produk yang tersedia.</p>
                    <p class="text-gray-500 text-sm">Nantikan koleksi terbaru dari pengrajin batik terbaik kami. ✨</p>
                </div>
            @endif
        </div>
    </section>

    {{-- TENTANG --}}
    <section id="tentang" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-indigo-500 font-semibold mb-3">
                        Tentang Batik Negeri Lasem
                    </p>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-5">
                        Mengangkat Warisan Batik ke Era Modern
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Batik Negeri Lasem lahir dari kecintaan pada batik dan semangat melestarikan warisan budaya
                        Indonesia. Kami bekerja langsung dengan pengrajin lokal agar setiap helai kain membawa cerita
                        tentang daerah, motif, dan tangan terampil yang mengerjakannya.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Dengan kurasi ketat, kami memastikan kualitas bahan, kerapian jahitan, dan kenyamanan saat
                        dipakai – baik untuk aktivitas harian maupun acara spesial.
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <span
                            class="px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-xs md:text-sm font-medium">
                            Batik Tulis
                        </span>
                        <span
                            class="px-3 py-1.5 rounded-full bg-purple-50 text-purple-700 text-xs md:text-sm font-medium">
                            Alat Canting
                        </span>
                        <span
                            class="px-3 py-1.5 rounded-full bg-amber-50 text-amber-700 text-xs md:text-sm font-medium">
                            Kualitas Terkurasi
                        </span>
                    </div>
                </div>
                <div class="relative">
                    <div
                        class="absolute -inset-4 bg-gradient-to-tr from-indigo-200 to-purple-200 rounded-3xl opacity-60 blur-lg">
                    </div>
                    <img src="{{ asset('storage/img/canting3.jpg') }}"
                        alt="Tentang Batik Negeri Lasem" class="relative rounded-3xl shadow-2xl w-full object-cover">
                </div>
            </div>
        </div>
    </section>

    {{-- KONTAK --}}
    <section id="kontak" class="py-20 bg-slate-950">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] text-amber-400 font-semibold mb-3">
                        Hubungi Kami
                    </p>
                    <h2 class="text-3xl md:text-4xl font-bold mb-5">
                        Ingin Tanya Produk?
                    </h2>
                    <p class="text-sm md:text-base text-slate-300 leading-relaxed mb-6">
                        Tim kami siap membantu memilih produk, konsultasi ukuran, hingga pemesanan khusus untuk kantor,
                        komunitas, atau acara spesialmu.
                    </p>
                    <div class="space-y-6 text-sm">
                        <div class="flex items-start gap-4 group">
                            <div
                                class="h-11 w-11 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-slate-950 transition-colors">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Telepon / WhatsApp</p>
                                <p class="text-slate-300">+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group">
                            <div
                                class="h-11 w-11 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center group-hover:bg-sky-500 group-hover:text-slate-950 transition-colors">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Email</p>
                                <p class="text-slate-300">batiktulisnegeri@gmail.id</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 group">
                            <div
                                class="h-11 w-11 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-slate-950 transition-colors">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Lokasi Toko</p>
                                <p class="text-slate-300">Jolotundo, Lasem, Rembang, Jawa Tengah, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <form class="bg-slate-900/80 border border-slate-800 rounded-3xl p-8 shadow-2xl space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-slate-200 mb-2">Nama</label>
                            <input type="text"
                                class="w-full rounded-xl border border-slate-700 bg-slate-950/70 text-slate-100 text-sm px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent placeholder:text-slate-500"
                                placeholder="Nama Anda">
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Email</label>
                                <input type="email"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950/70 text-slate-100 text-sm px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent placeholder:text-slate-500"
                                    placeholder="you@mail.com">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-200 mb-2">Telepon</label>
                                <input type="text"
                                    class="w-full rounded-xl border border-slate-700 bg-slate-950/70 text-slate-100 text-sm px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent placeholder:text-slate-500"
                                    placeholder="+62...">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-200 mb-2">Pesan</label>
                            <textarea rows="4"
                                class="w-full rounded-xl border border-slate-700 bg-slate-950/70 text-slate-100 text-sm px-3 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-transparent placeholder:text-slate-500"
                                placeholder="Tulis pertanyaan atau kebutuhan Anda"></textarea>
                        </div>
                        <button type="button"
                            class="w-full bg-gradient-to-r from-amber-400 via-amber-500 to-orange-600 text-slate-950 py-3.5 rounded-xl font-bold hover:from-amber-300 hover:to-orange-500 transition shadow-lg shadow-amber-500/30">
                            Kirim Pesan
                        </button>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Respon biasanya dalam 1x24 jam di hari kerja.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- MODAL PRODUK --}}
    <div id="product-modal-backdrop" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-[99] hidden"></div>
    <div id="product-modal" class="fixed inset-0 hidden items-center justify-center p-4 z-[100]" role="dialog"
        aria-modal="true" aria-labelledby="modal-title" aria-describedby="modal-description" tabindex="-1">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col md:flex-row transform modal-enter overflow-hidden border border-gray-100 relative"
            role="document">
            <button id="close-modal-button" type="button" aria-label="Tutup dialog"
                class="absolute top-4 right-4 bg-white/90 hover:bg-white text-gray-800 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:shadow-lg transition z-10 backdrop-blur-sm">
                <i class="fas fa-times text-lg" aria-hidden="true"></i>
            </button>

            <div class="w-full md:w-1/2 h-64 md:h-auto relative bg-gray-100">
                <img id="modal-image" src="https://placehold.co/600x600/e2e8f0/e2e8f0" alt="Detail Produk"
                    loading="lazy" decoding="async" class="w-full h-full object-cover">
            </div>

            <div class="w-full md:w-1/2 p-6 md:p-8 flex flex-col overflow-y-auto">
                <h2 id="modal-title"
                    class="text-2xl md:text-3xl font-bold text-gray-900 mb-2 font-['Playfair_Display']">
                    Nama Produk
                </h2>
                <p id="modal-price" class="text-3xl font-bold text-indigo-600 mb-5">
                    Rp 0
                </p>

                <div class="prose prose-sm text-gray-600 mb-5 flex-grow">
                    <p id="modal-description">Deskripsi lengkap produk akan ditampilkan di sini...</p>
                </div>

                <div
                    class="bg-indigo-50/60 rounded-2xl p-4 grid grid-cols-2 gap-y-4 gap-x-2 text-sm mb-6 border border-indigo-100">
                    <div>
                        <span
                            class="text-xs font-bold text-indigo-500 uppercase tracking-wider block mb-1">Motif</span>
                        <span id="modal-motif" class="text-gray-800 font-medium"></span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider block mb-1">Jenis
                            Kain</span>
                        <span id="modal-kain" class="text-gray-800 font-medium"></span>
                    </div>
                    <div>
                        <span
                            class="text-xs font-bold text-indigo-500 uppercase tracking-wider block mb-1">Ukuran</span>
                        <span id="modal-ukuran"
                            class="text-gray-800 font-medium bg-white px-2 py-0.5 rounded border border-indigo-200"></span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-indigo-500 uppercase tracking-wider block mb-1">Stok</span>
                        <span id="modal-stock" class="text-green-600 font-bold"></span>
                    </div>
                </div>

                <div class="mt-auto pt-5 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <div class="flex items-center border border-gray-300 rounded-xl bg-gray-50">
                            <button id="quantity-minus"
                                class="px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-l-xl transition font-bold">
                                -
                            </button>
                            <input id="quantity-input" type="number" value="1" min="1"
                                class="w-16 text-center border-none bg-transparent focus:ring-0 font-semibold text-gray-800">
                            <button id="quantity-plus"
                                class="px-4 py-3 text-gray-600 hover:bg-gray-200 rounded-r-xl transition font-bold">
                                +
                            </button>
                        </div>
                        <button id="add-to-cart-button" type="button" aria-label="Tambah ke keranjang"
                            class="w-full sm:w-auto flex-grow bg-indigo-600 text-white font-bold py-3.5 px-6 rounded-xl hover:bg-indigo-700 transition-all transform hover:shadow-lg hover:-translate-y-0.5">
                            <i class="fas fa-cart-plus mr-2" aria-hidden="true"></i>
                            Tambah ke Keranjang
                        </button>
                    </div>
                    <div id="modal-message-box" role="status" aria-live="polite" tabindex="-1"
                        class="mt-4 text-center p-3 rounded-xl text-sm hidden font-medium transition-all">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JS MODAL (logika tetap, styling disesuaikan) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalBackdrop = document.getElementById('product-modal-backdrop');
            const modal = document.getElementById('product-modal');
            const modalContent = modal.querySelector('.transform');
            const openModalButtons = document.querySelectorAll('.open-modal-button');
            const closeModalButton = document.getElementById('close-modal-button');

            const modalImage = document.getElementById('modal-image');
            const modalTitle = document.getElementById('modal-title');
            const modalPrice = document.getElementById('modal-price');
            const modalDescription = document.getElementById('modal-description');
            const modalStock = document.getElementById('modal-stock');
            const modalMotif = document.getElementById('modal-motif');
            const modalKain = document.getElementById('modal-kain');
            const modalUkuran = document.getElementById('modal-ukuran');
            const addToCartButton = document.getElementById('add-to-cart-button');

            const quantityInput = document.getElementById('quantity-input');
            const quantityMinus = document.getElementById('quantity-minus');
            const quantityPlus = document.getElementById('quantity-plus');

            const messageBox = document.getElementById('modal-message-box');
            let currentProductId = null;
            let currentProductStock = 0;
            let lastFocusedElement = null;

            const openModal = (productData) => {
                modalImage.src = productData.gambar;
                modalTitle.textContent = productData.nama;
                modalPrice.textContent = `Rp ${parseInt(productData.harga).toLocaleString('id-ID')}`;
                modalDescription.textContent = productData.deskripsi;
                modalStock.textContent = `${productData.stok} Tersisa`;
                modalMotif.textContent = productData.motif;
                modalKain.textContent = productData.kain;
                modalUkuran.textContent = productData.ukuran;

                currentProductId = productData.id;
                currentProductStock = parseInt(productData.stok);
                quantityInput.max = currentProductStock;
                quantityInput.value = 1;

                lastFocusedElement = document.activeElement;
                modalBackdrop.classList.remove('hidden');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                requestAnimationFrame(() => {
                    modalBackdrop.style.opacity = '1';
                    modalContent.classList.add('modal-enter-active');
                    modalContent.classList.remove('modal-enter');
                    modal.focus();
                    activateFocusTrap();
                });
            };

            const closeModal = () => {
                modalBackdrop.style.opacity = '0';
                modalContent.classList.add('modal-leave-active');
                modalContent.classList.remove('modal-enter-active');

                setTimeout(() => {
                    modalBackdrop.classList.add('hidden');
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    modalContent.classList.remove('modal-leave-active');
                    modalContent.classList.add('modal-enter');
                    messageBox.classList.add('hidden');

                    if (lastFocusedElement) {
                        try {
                            lastFocusedElement.focus();
                        } catch (e) {}
                    }
                    deactivateFocusTrap();
                }, 300);
            };

            const focusableSelectors =
                'a[href], area[href], input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), button:not([disabled]), iframe, object, embed, [tabindex]:not([tabindex="-1"]), [contenteditable]';
            let focusTrapHandler = null;

            const activateFocusTrap = () => {
                const focusable = Array.from(modal.querySelectorAll(focusableSelectors))
                    .filter(el => el.offsetParent !== null);
                if (!focusable.length) return;
                const first = focusable[0];
                const last = focusable[focusable.length - 1];

                focusTrapHandler = function(e) {
                    if (e.key === 'Tab') {
                        if (e.shiftKey) {
                            if (document.activeElement === first) {
                                e.preventDefault();
                                last.focus();
                            }
                        } else {
                            if (document.activeElement === last) {
                                e.preventDefault();
                                first.focus();
                            }
                        }
                    }
                };

                modal.addEventListener('keydown', focusTrapHandler);
            };

            const deactivateFocusTrap = () => {
                if (focusTrapHandler) {
                    modal.removeEventListener('keydown', focusTrapHandler);
                    focusTrapHandler = null;
                }
            };

            const showMessage = (message, isSuccess = true) => {
                messageBox.textContent = message;
                messageBox.classList.remove('hidden', 'bg-green-100', 'text-green-800', 'bg-red-100',
                    'text-red-800');
                if (isSuccess) {
                    messageBox.classList.add('bg-green-100', 'text-green-800');
                } else {
                    messageBox.classList.add('bg-red-100', 'text-red-800');
                }
                messageBox.classList.remove('hidden');
                try {
                    messageBox.focus();
                } catch (e) {}
            };

            openModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    openModal(this.dataset);
                });
            });

            closeModalButton.addEventListener('click', closeModal);
            modalBackdrop.addEventListener('click', closeModal);

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });

            quantityMinus.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            quantityPlus.addEventListener('click', () => {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < currentProductStock) {
                    quantityInput.value = currentValue + 1;
                }
            });

            addToCartButton.addEventListener('click', async function() {
                const productId = currentProductId;
                const quantity = parseInt(quantityInput.value);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content');

                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menambahkan...';

                try {
                    const response = await fetch('/keranjang/tambah', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            produk_id: productId,
                            kuantitas: quantity
                        })
                    });

                    const result = await response.json();

                    if (response.ok) {
                        showMessage('Produk berhasil ditambahkan ke keranjang!', true);

                        const cartBadge = document.getElementById('cart-badge');
                        if (cartBadge && result.total_items !== undefined) {
                            cartBadge.textContent = result.total_items;
                        }
                        setTimeout(closeModal, 2000);
                    } else {
                        throw new Error(result.message || 'Gagal menambahkan produk.');
                    }

                } catch (error) {
                    showMessage(error.message, false);
                } finally {
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-cart-plus mr-2"></i> Tambah ke Keranjang';
                }
            });
        });
    </script>
</x-landing-layout>
