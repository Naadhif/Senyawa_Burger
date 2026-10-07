<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Digital - Pesanan #{{ $pesanan->id_pesanan }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.4; color: #333; max-width: 600px; margin: 0 auto; background: #f4f4f4; padding: 20px; }
        .container { background: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, #e8500a, #ff6b2b); color: white; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 28px; font-weight: bold; }
        .info { padding: 25px; border-bottom: 2px solid #eee; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .label { font-weight: bold; color: #666; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px 8px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f9f9f9; font-weight: bold; }
        .total-row td { font-weight: bold; font-size: 18px; color: #e8500a; border-top: 2px solid #e8500a; }
        .footer { padding: 20px; text-align: center; color: #888; font-size: 14px; background: #f9f9f9; }
        @media (max-width: 480px) { body { padding: 10px; } .header h1 { font-size: 24px; } table { font-size: 14px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏪 CodeCraft Studio</h1>
            <p style="margin: 5px 0 0;">Struk Digital Pesanan</p>
        </div>

        <div class="info">
            <div class="info-row">
                <span class="label">No. Pesanan:</span>
                <span>#{{ str_pad($pesanan->id_pesanan, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Pelanggan:</span>
                <span>{{ $pesanan->nama }}</span>
            </div>
            <div class="info-row">
                <span class="label">Telepon:</span>
                <span>{{ $pesanan->no_telepon }}</span>
            </div>
            <div class="info-row">
                <span class="label">Tipe Order:</span>
                <span>{{ ucwords(str_replace('_', ' ', $pesanan->tipe_order)) }}</span>
            </div>
            <div class="info-row">
                <span class="label">Status Pembayaran:</span>
                <span style="color: {{ $pesanan->status_pembayaran == 'Lunas' ? '#28a745' : '#ffc107' }}; font-weight: bold;">
                    {{ $pesanan->status_pembayaran }}
                </span>
            </div>
            @if($pesanan->catatan)
            <div style="margin-top: 15px; padding: 10px; background: #fff3cd; border-left: 4px solid #ffc107;">
                <strong>Catatan:</strong> {{ $pesanan->catatan }}
            </div>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th style="text-align: right;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesanan->detailPesanan as $detail)
                <tr>
                    <td>
                        {{ $detail->menu->nama_menu ?? 'Menu #' . $detail->id_menu }}
                        @if($detail->kustomisasi)
                        <br><small style="color: #888;">{{ $detail->kustomisasi }}</small>
                        @endif
                    </td>
                    <td style="text-align: right;">{{ $detail->jumlah }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table style="margin-top: 0;">
            <tr class="total-row">
                <td colspan="3">TOTAL</td>
                <td style="text-align: right;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Terima kasih atas pembelian Anda di CodeCraft Studio!</p>
            <p>Struk ini dapat dicetak atau disimpan sebagai bukti pembayaran.</p>
            <p>Tanggal: {{ $pesanan->created_at ? \Carbon\Carbon::parse($pesanan->created_at)->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
</body>
</html>

