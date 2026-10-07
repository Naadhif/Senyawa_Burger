<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
        />
        <title>Menunggu Pembayaran Kasir</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>
    <body>
        <div class="header">
            <h1>Silakan ke Kasir</h1>
        </div>

        <!-- Info Pembayaran -->
        <div
            class="section"
            style="padding-top: 40px; text-align: center"
            id="waitingSection"
        >
            <div
                style="
                    margin-bottom: 20px;
                    display: flex;
                    justify-content: center;
                "
            >
                <div
                    style="
                        width: 80px;
                        height: 80px;
                        background: rgba(232, 80, 10, 0.1);
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    "
                >
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        style="
                            width: 40px;
                            height: 40px;
                            stroke: var(--orange);
                            stroke-width: 2;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                        "
                    >
                        <rect x="2" y="5" width="20" height="14" rx="2" />
                        <line x1="2" y1="10" x2="22" y2="10" />
                    </svg>
                </div>
            </div>
            <h2
                style="
                    font-family: &quot;Bebas Neue&quot;, cursive;
                    font-size: 1.8rem;
                    color: var(--dark);
                    letter-spacing: 1px;
                    margin-bottom: 8px;
                "
            >
                Menyetujui Pembayaran
            </h2>
            <p
                style="
                    font-size: 0.95rem;
                    color: var(--gray);
                    margin-bottom: 24px;
                    line-height: 1.5;
                    padding: 0 10px;
                "
            >
                Pesanan atas nama
                <strong style="color: var(--dark)">{{ $pesanan->nama }}</strong>
                telah kami terima.<br />
                Silakan lakukan pembayaran di kasir untuk menyelesaikan pesanan
                Anda.
            </p>

            <!-- Loading indicator -->
            <div
                style="
                    display: flex;
                    justify-content: center;
                    gap: 8px;
                    margin-bottom: 10px;
                "
            >
                <div
                    style="
                        width: 8px;
                        height: 8px;
                        background: var(--orange);
                        border-radius: 50%;
                        animation: bounce 1s infinite alternate;
                    "
                ></div>
                <div
                    style="
                        width: 8px;
                        height: 8px;
                        background: var(--orange-light);
                        border-radius: 50%;
                        animation: bounce 1s infinite alternate;
                        animation-delay: 0.2s;
                    "
                ></div>
                <div
                    style="
                        width: 8px;
                        height: 8px;
                        background: #ff9d71;
                        border-radius: 50%;
                        animation: bounce 1s infinite alternate;
                        animation-delay: 0.4s;
                    "
                ></div>
            </div>
            <div
                style="font-size: 0.85rem; color: var(--gray); font-weight: 600"
            >
                Menunggu konfirmasi kasir...
            </div>
        </div>

        <!-- Rincian Pesanan -->
        <div class="section" style="animation-delay: 0.2s" id="detailSection">
            <div
                style="
                    background: var(--card-bg);
                    border: 2px solid #eee;
                    border-radius: 16px;
                    padding: 20px;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
                "
            >
                <div
                    style="
                        border-bottom: 2px dashed #eee;
                        padding-bottom: 16px;
                        margin-bottom: 16px;
                    "
                >
                    <div
                        style="
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-end;
                        "
                    >
                        <span
                            style="
                                font-weight: 800;
                                color: var(--dark);
                                font-size: 0.95rem;
                            "
                            >Total Pembayaran</span
                        >
                        <span
                            style="
                                font-size: 1.4rem;
                                font-weight: 800;
                                color: var(--orange);
                            "
                            >Rp{{ number_format($pesanan->total_harga, 0, ',',
                            '.') }}</span
                        >
                    </div>
                </div>

                <div>
                    <p
                        style="
                            font-size: 0.85rem;
                            color: var(--gray);
                            font-weight: 700;
                            margin-bottom: 12px;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                        "
                    >
                        Daftar Pesanan
                    </p>
                    @foreach($pesanan->detailPesanan as $detail)
                    <div
                        style="
                            display: flex;
                            justify-content: space-between;
                            align-items: flex-start;
                            margin-bottom: 12px;
                            font-size: 0.9rem;
                        "
                    >
                        <div style="display: flex; gap: 8px">
                            <span style="color: var(--orange); font-weight: 800"
                                >{{ $detail->jumlah }}x</span
                            >
                            <div style="display: flex; flex-direction: column">
                                <span
                                    style="color: var(--dark); font-weight: 700"
                                    >{{ $detail->menu->nama_menu ?? 'Item'
                                    }}</span
                                >
                                @if($detail->kustomisasi)
                                <span
                                    style="
                                        color: var(--gray);
                                        font-size: 0.8rem;
                                        margin-top: 2px;
                                    "
                                    >Catatan: {{ $detail->kustomisasi }}</span
                                >
                                @endif
                            </div>
                        </div>
                        <span style="color: var(--dark); font-weight: 700"
                            >Rp{{ number_format($detail->harga_satuan *
                            $detail->jumlah, 0, ',', '.') }}</span
                        >
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Success Animation -->
        <div
            id="successAnim"
            style="
                display: none;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                margin-top: 60px;
                animation: fadeUp 0.4s ease;
            "
        >
            <svg
                viewBox="0 0 24 24"
                fill="none"
                style="
                    width: 90px;
                    height: 90px;
                    stroke: #3cb878;
                    stroke-width: 3.5;
                    stroke-linecap: round;
                    stroke-linejoin: round;
                    margin-bottom: 16px;
                    background: #eafaee;
                    padding: 15px;
                    border-radius: 50%;
                "
            >
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            <h2
                style="
                    font-family: &quot;Bebas Neue&quot;, cursive;
                    font-size: 1.8rem;
                    color: #3cb878;
                    letter-spacing: 1px;
                    margin-bottom: 6px;
                "
            >
                Pembayaran Lunas!
            </h2>
            <p style="font-size: 0.95rem; color: var(--gray); font-weight: 600">
                Kembali ke halaman utama...
            </p>
        </div>
    </body>
</html>

<!--Css-->
<style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    :root {
        --orange: #e8500a;
        --orange-light: #ff6b2b;
        --dark: #1a1008;
        --cream: #f5f0eb;
        --card-bg: #ffffff;
        --text: #1a1008;
        --gray: #888;
    }
    body {
        font-family: "Nunito", sans-serif;
        background: var(--cream);
        color: var(--text);
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        overflow-x: hidden;
        padding-bottom: 50px;
    }
    /* ── Header ── */
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
        color: var(--dark);
        letter-spacing: 2px;
    }
    .section {
        padding: 18px 16px 0;
        animation: fadeUp 0.4s ease both;
    }
    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounce {
        from {
            transform: translateY(0);
            }
        to {
            transform: translateY(-8px);
            }
    }
</style>

<!--Javascript-->
<script>
    let isSuccess = false;

    function checkStatus() {
        if (isSuccess) return;

        fetch(`/api/pesanan/status/{{ $pesanan->id_pesanan }}`)
            .then((response) => response.json())
            .then((data) => {
                if (data.success && data.status_pembayaran === "Lunas") {
                    isSuccess = true;

                    document.getElementById("waitingSection").style.display =
                        "none";
                    document.getElementById("detailSection").style.display =
                        "none";

                    document.querySelector(".header h1").textContent =
                        "Selesai";
                    document.getElementById("successAnim").style.display =
                        "flex";

                    setTimeout(() => {
                        window.location.href = "{{ url('/') }}";
                    }, 2500);
                }
            })
            .catch((error) => console.error("Error checking status:", error));
    }

    // Mulai polling setiap 3 detik
    setInterval(checkStatus, 3000);
</script>
