<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pesanan #{{ $pesanan->id_pesanan }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px dashed #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #e8500a; /* Warna khas Senyawa Burger */
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #666;
        }
        .info {
            width: 100%;
            margin-bottom: 20px;
        }
        .info td {
            padding: 4px 0;
            vertical-align: top;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            text-align: left;
            border-bottom: 1px solid #333;
            padding: 8px 0;
            font-size: 12px;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 10px 0;
            border-bottom: 1px dashed #ddd;
            vertical-align: top;
        }
        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        
        .item-name { font-weight: bold; font-size: 14px; }
        .item-note { font-size: 11px; color: #777; font-style: italic; margin-top: 3px; }
        
        .total-section td {
            padding-top: 15px;
            font-size: 16px;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #555;
            border-top: 2px dashed #333;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Senyawa Burger</h1>
        <p>Struk Pembayaran</p>
    </div>

    <table class="info">
        <tr>
            <td width="20%"><strong>Tanggal</strong></td>
            <td width="30%">: {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y, H:i') }}</td>
        </tr>
        <tr>
            <td><strong>Pelanggan</strong></td>
            <td>: {{ $pesanan->nama }}</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th width="50%">Deskripsi Menu</th>
                <th width="15%" class="text-center">Jumlah</th>
                <th width="35%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pesanan->detailPesanan as $detail)
            <tr>
                <td>
                    <div class="item-name">{{ $detail->menu ? $detail->menu->nama_menu : 'Unknown Menu' }}</div>
                    @if($detail->kustomisasi)
                        <div class="item-note">Catatan: {{ $detail->kustomisasi }}</div>
                    @endif
                </td>
                <td class="text-center">{{ $detail->jumlah }}x</td>
                <td class="text-right">Rp{{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-section">
                <td colspan="2" class="text-right">TOTAL KESELURUHAN:</td>
                <td class="text-right">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <strong>Terima kasih atas kunjungan Anda!</strong><br>
        Harap simpan struk ini sebagai bukti pembayaran yang sah.
    </div>

</body>
</html>