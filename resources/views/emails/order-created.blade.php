<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Baru - Batik Nusantara</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f3f4f6; color: #1f2937; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .header { background: linear-gradient(135deg, #4f46e5, #7c3aed); padding: 40px; text-align: center; color: white; }
        .header h1 { margin: 0; font-size: 24px; font-weight: bold; }
        .content { padding: 30px; }
        .order-box { background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 12px; padding: 20px; text-align: center; margin: 20px 0; }
        .order-id { font-size: 24px; font-weight: bold; color: #4f46e5; letter-spacing: 1px; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table td { padding: 12px 0; border-bottom: 1px solid #e5e7eb; }
        .details-table tr:last-child td { border-bottom: none; }
        .total-row { font-weight: bold; color: #4f46e5; font-size: 18px; }
        .btn { display: inline-block; background: #4f46e5; color: white; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Pesanan Diterima!</h1>
                <p>Terima kasih telah berbelanja di Batik Nusantara</p>
            </div>
            <div class="content">
                <p>Halo <strong>{{ $customer->nama_pelanggan ?? 'Pelanggan' }}</strong>,</p>
                <p>Pesanan Anda telah kami terima dan menunggu pembayaran.</p>

                <div class="order-box">
                    <p style="margin:0; font-size:12px; color:#6b7280; text-transform:uppercase;">Nomor Pesanan</p>
                    <div class="order-id">{{ $pesanan->kode_pesanan }}</div>
                </div>

                <table class="details-table">
                    <tr>
                        <td>Status</td>
                        <td style="text-align: right;"><strong>{{ ucfirst($pesanan->status_pesanan) }}</strong></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td style="text-align: right;">{{ $pesanan->tanggal_pesanan->format('d M Y') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td>Total</td>
                        <td style="text-align: right;">Rp {{ number_format($pesanan->total_keseluruhan, 0, ',', '.') }}</td>
                    </tr>
                </table>

                <center>
                    <a href="{{ route('pembayaran.sukses', $pesanan->kode_pesanan) }}" class="btn">Lihat Detail Pesanan</a>
                </center>
            </div>
        </div>
    </div>
</body>
</html>
