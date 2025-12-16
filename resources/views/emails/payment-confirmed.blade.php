<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Dikonfirmasi</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f3f4f6; color: #1f2937; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        /* Green Gradient for Payment Success */
        .header { background: linear-gradient(135deg, #059669, #10b981); padding: 40px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; }
        .content { padding: 30px; }
        .success-box { background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px; padding: 15px; text-align: center; margin: 20px 0; color: #047857; font-weight: bold; }
        .btn { display: inline-block; background: #059669; color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Pembayaran Dikonfirmasi!</h1>
                <p>Pesanan Anda sedang diproses</p>
            </div>
            <div class="content">
                <p>Halo <strong>{{ $customer->nama_pelanggan ?? 'Pelanggan' }}</strong>,</p>
                <div class="success-box">✅ Lunas & Terverifikasi</div>
                <p>Kami telah menerima pembayaran Anda sebesar <strong>Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</strong>.</p>
                <p>Barang akan segera kami kemas dan kirimkan ke alamat tujuan.</p>
                <center>
                    <a href="{{ route('pesanan.index') }}" class="btn">Lacak Pesanan</a>
                </center>
            </div>
        </div>
    </div>
</body>
</html>
