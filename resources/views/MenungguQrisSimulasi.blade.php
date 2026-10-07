<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Menunggu Pembayaran QRIS</title>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
    </head>
    <body>
        <div class="header">
            <h1 id="headerTitle">Pembayaran QRIS</h1>
        </div>

        {{-- ── WAITING SECTION ── --}}
        <div class="section" id="waitingSection">
            <div style="text-align: center; padding-top: 32px;">
                <h2 class="scan-title">Scan QR Code</h2>
                <p class="scan-sub">
                    Silakan scan QR di bawah menggunakan aplikasi dompet digital.<br>
                    Pembayaran atas nama <strong style="color: var(--dark)">{{ $pesanan->nama }}</strong>.
                </p>

                {{-- QR Image --}}
                <div class="qr-wrap">
                    <img
                        id="qrisImage"
                        src="https://quickchart.io/qr?size=220&text={{ urlencode($qrString) }}"
                        alt="QRIS Code"
                        onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode($qrString) }}';"
                    />
                    <div class="scan-line" id="scanLine"></div>
                </div>

                {{-- Amount --}}
                <p class="amount-label">Total Pembayaran</p>
                <p class="amount-value">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>

                {{-- Countdown Ring --}}
                <div class="ring-wrap">
                    <svg viewBox="0 0 80 80" width="80" height="80">
                        <circle class="ring-track" cx="40" cy="40" r="32"/>
                        <circle class="ring-fill" id="ringFill" cx="40" cy="40" r="32"/>
                    </svg>
                    <div class="ring-num" id="countNum">10</div>
                </div>
                <p class="ring-label">detik simulasi tersisa</p>

                {{-- Dots --}}
                <div class="dots">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <p class="wait-label">Menunggu konfirmasi pembayaran...</p>
            </div>
        </div>

        {{-- ── ORDER DETAIL CARD ── --}}
        <div class="section" id="detailSection">
            <div class="detail-card">
                <p class="detail-title">Rincian Pesanan</p>
                @foreach($pesanan->detailPesanan as $detail)
                <div class="detail-row">
                    <div>
                        <span class="detail-qty">{{ $detail->jumlah }}x</span>
                        <span class="detail-name">{{ $detail->menu->nama_menu ?? 'Item' }}</span>
                        @if($detail->kustomisasi)
                            <br><small class="detail-note">{{ $detail->kustomisasi }}</small>
                        @endif
                    </div>
                    <span class="detail-price">Rp{{ number_format($detail->harga_satuan * $detail->jumlah, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ── SUCCESS SECTION ── --}}
        <div id="successSection" style="display: none; text-align: center; padding: 40px 16px;">
            <div class="success-circle">
                <svg viewBox="0 0 24 24" fill="none">
                    <polyline points="20 6 9 17 4 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="success-title">Pembayaran Berhasil!</h2>
            <p class="success-sub">Transaksi QRIS dikonfirmasi — status pesanan diperbarui ke <strong>Lunas</strong>.</p>

            <div class="success-card">
                <div class="srow"><span class="slbl">Nama</span><span class="sval">{{ $pesanan->nama }}</span></div>
                <div class="srow"><span class="slbl">Total</span><span class="sval">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span></div>
                <div class="srow"><span class="slbl">Metode</span><span class="sval">QRIS</span></div>
                <div class="srow"><span class="slbl">Status</span><span class="sval"><span class="badge-lunas">Lunas</span></span></div>
            </div>

            <p class="redirect-msg" id="redirectMsg">Mengalihkan ke halaman utama dalam 3 detik...</p>
        </div>
    </body>
</html>

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --orange: #e8500a;
        --orange-light: #ff6b2b;
        --dark: #1a1008;
        --cream: #f5f0eb;
        --card-bg: #ffffff;
        --gray: #888;
        --green: #3cb878;
        --radius: 16px;
    }

    body {
        font-family: "Nunito", sans-serif;
        background: var(--cream);
        color: var(--dark);
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        overflow-x: hidden;
        padding-bottom: 60px;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        border-bottom: 2px solid #eee;
        background: var(--card-bg);
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .header h1 {
        font-family: "Bebas Neue", cursive;
        font-size: 1.3rem;
        font-weight: 400;
        letter-spacing: 2px;
    }

    .section { padding: 18px 16px 0; animation: fadeUp 0.4s ease both; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .scan-title {
        font-family: "Bebas Neue", cursive;
        font-size: 1.6rem;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }
    .scan-sub {
        font-size: 0.88rem;
        color: var(--gray);
        line-height: 1.5;
        margin-bottom: 20px;
    }

    /* QR Box */
    .qr-wrap {
        width: 220px;
        height: 220px;
        margin: 0 auto 12px;
        border: 2px solid #eee;
        border-radius: 12px;
        background: #fff;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qr-wrap img { width: 200px; height: 200px; display: block; }
    .scan-line {
        position: absolute;
        left: 0; right: 0;
        height: 2px;
        background: var(--orange);
        opacity: 0.75;
        animation: scan 2s linear infinite;
    }
    @keyframes scan { 0%{top:0} 100%{top:220px} }

    .amount-label { font-size: 0.8rem; color: var(--gray); font-weight: 700; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
    .amount-value { font-size: 1.6rem; font-weight: 800; color: var(--orange); margin-bottom: 16px; }

    /* Countdown ring */
    .ring-wrap {
        width: 80px;
        height: 80px;
        margin: 0 auto 6px;
        position: relative;
    }
    .ring-wrap svg { transform: rotate(-90deg); }
    .ring-track { fill: none; stroke: #eee; stroke-width: 5; }
    .ring-fill  { fill: none; stroke: var(--orange); stroke-width: 5; stroke-linecap: round; stroke-dasharray: 201; stroke-dashoffset: 201; transition: stroke-dashoffset 1s linear, stroke 0.5s; }
    .ring-num {
        position: absolute; inset: 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; font-weight: 800; color: var(--dark);
    }
    .ring-label { font-size: 0.78rem; color: var(--gray); font-weight: 600; margin-bottom: 12px; }

    /* Dots */
    .dots { display: flex; justify-content: center; gap: 7px; margin-bottom: 8px; }
    .dot { width: 8px; height: 8px; border-radius: 50%; background: var(--orange); animation: bounce 1s ease-in-out infinite; }
    .dot:nth-child(2){animation-delay:.2s} .dot:nth-child(3){animation-delay:.4s}
    @keyframes bounce { 0%,100%{transform:translateY(0);opacity:1} 50%{transform:translateY(-5px);opacity:.5} }
    .wait-label { font-size: 0.82rem; color: var(--gray); font-weight: 600; }

    /* Detail card */
    .detail-card {
        background: var(--card-bg);
        border: 2px solid #eee;
        border-radius: var(--radius);
        padding: 18px;
        margin-top: 16px;
    }
    .detail-title { font-size: 0.82rem; font-weight: 800; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; }
    .detail-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; font-size: 0.9rem; }
    .detail-qty { color: var(--orange); font-weight: 800; margin-right: 6px; }
    .detail-name { font-weight: 700; }
    .detail-note { color: var(--gray); font-size: 0.78rem; }
    .detail-price { font-weight: 700; flex-shrink: 0; }

    /* Success */
    .success-circle {
        width: 80px; height: 80px;
        border-radius: 50%;
        background: rgba(60,184,120,0.12);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        animation: popIn 0.4s cubic-bezier(0.22,1,0.36,1);
    }
    .success-circle svg { width: 40px; height: 40px; stroke: var(--green); stroke-width: 3; fill: none; }
    @keyframes popIn { from{transform:scale(0.5);opacity:0} to{transform:scale(1);opacity:1} }

    .success-title { font-family: "Bebas Neue", cursive; font-size: 2rem; color: var(--green); letter-spacing: 1px; margin-bottom: 6px; }
    .success-sub { font-size: 0.88rem; color: var(--gray); margin-bottom: 20px; line-height: 1.5; }

    .success-card {
        background: var(--card-bg);
        border: 2px solid #eee;
        border-radius: var(--radius);
        padding: 16px;
        margin: 0 auto 16px;
        max-width: 320px;
        text-align: left;
    }
    .srow { display: flex; justify-content: space-between; font-size: 0.88rem; padding: 5px 0; border-bottom: 1px solid #f0ede9; }
    .srow:last-child { border-bottom: none; }
    .slbl { color: var(--gray); font-weight: 600; }
    .sval { font-weight: 700; }
    .badge-lunas { background: rgba(60,184,120,0.12); color: var(--green); font-size: 0.78rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; }

    .redirect-msg { font-size: 0.82rem; color: var(--gray); font-weight: 600; }
</style>

<script>
    const TOTAL      = 10;
    const CIRCUMF    = 2 * Math.PI * 32; // r=32
    const reference  = @json($reference);
    const pesananId  = @json($pesanan->id_pesanan);

    let remaining = TOTAL;
    let countTimer;
    let isSuccess = false;

    const ringFill = document.getElementById('ringFill');
    const countNum = document.getElementById('countNum');

    function updateRing() {
        const pct    = remaining / TOTAL;
        const offset = CIRCUMF * (1 - pct);
        ringFill.style.strokeDashoffset = offset;
        countNum.textContent = remaining;
        ringFill.style.stroke = pct > 0.4 ? 'var(--orange)' : '#e85555';
    }

    /* ── Auto-simulate: setelah 10 detik panggil endpoint simulate-success ── */
    // async function simulatePayment() {
    //     if (isSuccess) return;
    //     try {
    //         const res  = await fetch(`/api/pembayaran/simulate-success/${reference}`, {
    //             method : 'POST',
    //             headers: { 'Content-Type': 'application/json' }
    //         });
    //         const data = await res.json();
    //         if (data.success || data.message === 'Pesanan sudah lunas sebelumnya.') {
    //             isSuccess = true;
    //             showSuccess();
    //         }
    //     } catch (e) {
    //         console.error('Simulate error:', e);
    //         /* Tetap tampilkan success di frontend walau request gagal */
    //         isSuccess = true;
    //         showSuccess();
    //     }
    // }
    async function simulatePayment() {
    if (isSuccess) return;
    try {
        // Ambil token CSRF dari meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const res  = await fetch(`/api/pembayaran/simulate-success/${reference}`, {
            method : 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // Sisipkan token di sini
            }
        });
        
        const data = await res.json();
        
        if (data.success || data.message === 'Pesanan sudah lunas sebelumnya.') {
            isSuccess = true;
            showSuccess();
        } else {
            console.error('Gagal update database:', data.message);
            // Opsional: Anda bisa tambahkan alert() di sini jika gagal
        }
    } catch (e) {
        console.error('Simulate error:', e);
        // HAPUS showSuccess() dari sini agar tidak "bohong" jika error betulan
        alert("Terjadi kesalahan saat mengonfirmasi pembayaran.");
    }
}

    function showSuccess() {
        document.getElementById('waitingSection').style.display  = 'none';
        document.getElementById('detailSection').style.display   = 'none';
        document.getElementById('successSection').style.display  = 'block';
        document.getElementById('headerTitle').textContent       = 'Pembayaran Berhasil';

        /* Bersihkan localStorage keranjang */
        localStorage.removeItem('cart');

        let rd = 3;
        const rdTimer = setInterval(() => {
            rd--;
            const msg = document.getElementById('redirectMsg');
            if (rd > 0) {
                msg.textContent = `Mengalihkan ke halaman utama dalam ${rd} detik...`;
            } else {
                msg.textContent = 'Mengarahkan...';
                clearInterval(rdTimer);
                window.location.href = '/';
            }
        }, 1000);
    }

    /* ── Countdown logic ── */
    updateRing();
    countTimer = setInterval(() => {
        remaining--;
        updateRing();
        if (remaining <= 0) {
            clearInterval(countTimer);
            simulatePayment();
        }
    }, 1000);

    /* ── Polling fallback tiap 5 detik (kalau user sudah bayar duluan) ── */
    const pollTimer = setInterval(async () => {
        if (isSuccess) { clearInterval(pollTimer); return; }
        try {
            const res  = await fetch(`/api/pesanan/status/${pesananId}`);
            const data = await res.json();
            if (data.success && data.status_pembayaran === 'Lunas') {
                isSuccess = true;
                clearInterval(countTimer);
                clearInterval(pollTimer);
                showSuccess();
            }
        } catch (e) { /* ignore */ }
    }, 5000);
</script>