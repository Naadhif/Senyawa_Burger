<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Detail Riwayat Pesanan – Kasir</title>
        <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
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
                --blue: #0e0ae8;
                --orange-bg: #ff6b2b;
                --orange-light: #2b80ff;
                --green: #4caf50;
                --green-dark: #3d8b40;
                --red: #e85555;
                --red-dark: #c83c3c;
                --surface: #ffffff;
                --border: #eeeeee;
                --text-dark: #1a1008;
                --text-muted: #888888;
                --radius: 16px;
                --pill: 100px;
                --cream: #faefe2;
                --dark: #1a1008;
                --card-bg: #ffffff;
                --text: #1a1008;
                --gray: #888;
            }

            body {
                font-family: "Nunito", sans-serif;
                background: var(--cream);
                color: var(--text);
                min-height: 100vh;
                display: flex;
            }

            /* ══ SIDEBAR ══ */
            .sidebar {
                width: 240px;
                min-height: 100vh;
                background: var(--orange-bg);
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 36px 20px 28px;
                flex-shrink: 0;
            }

            .avatar {
                width: 96px;
                height: 96px;
                border-radius: 50%;
                background: rgba(0, 0, 0, 0.22);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 14px;
            }
            .avatar svg {
                width: 58px;
                height: 58px;
                fill: rgba(0, 0, 0, 0.55);
            }

            .sidebar-name {
                font-family: "Nunito", sans-serif;
                font-size: 17px;
                font-weight: 700;
                color: #fff;
                text-align: center;
                letter-spacing: normal;
                margin-bottom: 0;
                line-height: inherit;
            }
            .sidebar-id {
                font-size: 13.5px;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.85);
                margin-top: 4px;
                margin-bottom: 28px;
                letter-spacing: 0.5px;
            }

            .nav-item {
                display: flex;
                align-items: center;
                gap: 10px;
                width: 100%;
                padding: 11px 14px;
                border-radius: var(--radius);
                cursor: pointer;
                font-size: 15px;
                font-weight: 700;
                color: #fff;
                text-decoration: none;
                transition: background 0.2s;
                margin-bottom: 8px;
            }
            .nav-item:hover {
                background: rgba(0, 0, 0, 0.12);
                color: #fff;
            }
            .nav-item.active {
                background: rgba(0, 0, 0, 0.18);
                color: #fff;
            }
            .nav-item svg {
                width: 18px;
                height: 18px;
                stroke: #fff;
                stroke-width: 2;
                fill: none;
                flex-shrink: 0;
            }

            .sidebar-footer {
                margin-top: auto;
            }

            .btn-logout {
                background: var(--red);
                color: #fff;
                border: none;
                border-radius: 20px;
                padding: 9px 24px;
                font-family: "Nunito", sans-serif;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
                transition: background 0.2s, transform 0.15s;
            }
            .btn-logout:hover {
                background: var(--red-dark);
                box-shadow: 0 4px 12px rgba(232, 85, 85, 0.3);
                transform: translateY(-2px);
            }
            .btn-logout:active {
                transform: scale(0.96);
            }

            /* ══ MAIN ══ */
            .main {
                flex: 1;
                padding: 32px 36px 40px;
                overflow-y: auto;
            }

            .page-title {
                font-family: "Bebas Neue", cursive;
                font-size: 42px;
                font-weight: 400;
                color: var(--text-dark);
                letter-spacing: 2px;
                text-transform: uppercase;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--orange);
                margin-bottom: 28px;
            }

            /* ══ ORDER TABLE CARD ══ */
            .order-card {
                background: var(--surface);
                border: 2px solid var(--border);
                border-radius: var(--radius);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
                overflow: hidden;
                margin-bottom: 24px;
            }

            .order-card-header {
                padding: 15px 20px;
                font-family: "Nunito", sans-serif;
                font-size: 15px;
                font-weight: 800;
                color: var(--text-dark);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-bottom: 1.5px solid var(--border);
                background: var(--surface);
            }

            .order-table {
                width: 100%;
                border-collapse: collapse;
            }

            .order-table thead tr th {
                padding: 12px 20px;
                font-family: "Nunito", sans-serif;
                font-size: 11.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: var(--text-muted);
                border-bottom: 1.5px solid var(--border);
                text-align: left;
                background: #fafaf8;
            }

            .order-table thead tr th:not(:first-child) {
                text-align: center;
            }

            .order-table tbody tr {
                transition: background 0.15s;
            }
            .order-table tbody tr:hover {
                background: #f5f2ee;
            }

            .order-table tbody tr td {
                padding: 16px 20px;
                font-family: "Nunito", sans-serif;
                font-size: 14px;
                font-weight: 600;
                color: var(--text-dark);
                border-bottom: 1px solid var(--border);
                vertical-align: top;
            }

            .order-table tbody tr:last-child td {
                border-bottom: none;
            }

            .order-table tbody tr td:not(:first-child) {
                text-align: center;
                color: var(--text-muted);
                font-size: 14px;
            }

            .item-name {
                font-family: "Bebas Neue", cursive;
                font-size: 1.2rem;
                color: var(--dark);
                letter-spacing: 1px;
                margin-bottom: 10px;
            }

            .item-note {
                display: flex;
                align-items: center;
                gap: 6px;
                margin-top: 5px;
                font-size: 0.85rem;
                color: var(--gray);
                font-style: italic;
            }
            .item-note svg {
                width: 15px;
                height: 15px;
                stroke: var(--gray);
                stroke-width: 1.8;
                flex-shrink: 0;
                fill: none;
            }

            .qty-cell {
                font-size: 1.4rem;
                font-weight: 800;
                color: var(--dark);
            }

            .total-cell {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--dark);
            }

            .empty-row td {
                height: 280px;
            }

            /* ══ BOTTOM AREA ══ */
            .bottom-area {
                display: flex;
                align-items: flex-start;
                gap: 24px;
            }

            .notes-block {
                flex: 1;
            }

            .notes-block label {
                font-size: 0.9rem;
                font-weight: 700;
                color: var(--dark);
                display: block;
                margin-bottom: 8px;
            }

            .notes-block textarea {
                width: 100%;
                height: 100px;
                border: 1.5px solid var(--border);
                border-radius: var(--radius);
                padding: 9px 12px;
                font-family: "Nunito", sans-serif;
                font-size: 13.5px;
                color: var(--text-dark);
                background: #fff;
                resize: none;
                outline: none;
            }

            .total-block {
                flex-shrink: 0;
                text-align: right;
                min-width: 200px;
            }

            .total-label {
                font-size: 0.85rem;
                font-weight: 700;
                color: var(--gray);
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .total-amount {
                font-size: 1.8rem;
                font-weight: 800;
                color: var(--dark);
                margin-bottom: 14px;
                margin-top: 2px;
            }

            /* Status Label Statis untuk Riwayat */
            .status-lunas-label {
                background: rgba(60, 184, 120, 0.1);
                color: var(--green);
                border: 2px solid var(--green);
                border-radius: 50px;
                padding: 12px 20px;
                font-family: "Nunito", sans-serif;
                font-size: 0.9rem;
                font-weight: 700;
                display: inline-block;
                width: 100%;
                text-align: center;
                cursor: default;
            }

            /* ══ ACTION BUTTONS ══ */
            .action-buttons {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 16px;
                width: 800px;
                margin: 28px auto 0;
                align-content: center;
                justify-content: center;
                width: 100%;
            }

            /* Ubah style btn-cetak menjadi seperti btn-selesai */
            .btn-cetak {
                width: 100%; /* Agar tombol membentang penuh / proporsional */
                padding: 16px;
                background: #2b78e4; /* Warna diubah menjadi oranye */
                color: #fff;
                border: none;
                width: 1000px;
                border-radius: 50px;
                font-family: "Nunito", sans-serif;
                font-size: 1rem;
                font-weight: 700;
                cursor: pointer;
                transition: transform 0.15s, box-shadow 0.15s, background 0.2s;
            }
            .btn-cetak:hover {
                background: #1a5bb8;
                transform: translateY(-2px);
                box-shadow: 0 8px 28px rgba(43, 120, 228, 0.5);
            }
            .btn-cetak:active {
                transform: scale(0.98);
            }
        </style>
    </head>
    <body>
        <aside class="sidebar">
            <div class="avatar">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                </svg>
            </div>

            <p class="sidebar-name">Kasir</p>
            <p class="sidebar-id"></p>
            
            <a class="nav-item" href="/kasir/antrian">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
                Daftar Antrian
            </a>

            <a class="nav-item active" href="/kasir/riwayat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Pesanan Selesai
            </a>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </aside>

        <main class="main">
            <h1 class="page-title">Detail Riwayat Pesanan ( {{ $pesanan->nama }} )</h1>

            <div class="order-card">
                <div class="order-card-header">Daftar Detail Pesanan</div>
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Jumlah</th>
                            <th>Total Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody id="orderTableBody">
                        </tbody>
                </table>
            </div>

            <div class="bottom-area">
                <div class="notes-block">
                    <label>Catatan Lainnya</label>
                    <textarea
                        id="catatanLainnya"
                        placeholder="Tidak ada catatan pesanan."
                        readonly
                        style="background-color: transparent;"
                    >{{ trim($pesanan->catatan ?? '') ?: '-' }}</textarea>
                </div>

                <div class="total-block">
                    <div class="total-label">Total</div>
                    <div class="total-amount" id="grandTotal">Rp0</div>
                    <div class="status-lunas-label">✓ Sudah Lunas</div>
                </div>
            </div>

            <div class="action-buttons">
                <button class="btn-cetak" onclick="cetakStruk()">
                    Cetak Struk
                </button>
            </div>
        </main>

        <script>
            /* ── Data ── */
            const orders = {!! json_encode($orders) !!};

            /* ── Helpers ── */
            function fmt(n) {
                return (
                    "Rp" +
                    parseInt(n || 0)
                        .toLocaleString("id-ID")
                        .replace(/\./g, ".")
                        .replace(",", ".")
                );
            }

            function recalc() {
                const total = orders.reduce((s, o) => s + o.price * o.qty, 0);
                document.getElementById("grandTotal").textContent = fmt(total);
            }

            /* ── Render Table ── */
            function renderTable() {
                const tbody = document.getElementById("orderTableBody");
                tbody.innerHTML = "";

                orders.forEach((item) => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>
                            <div class="item-name">${item.name}</div>
                            <div class="item-note" style="${item.note ? "" : "display:none;"}">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                                ${item.note}
                            </div>
                        </td>
                        <td>
                            <span class="qty-cell">${item.qty}</span>
                        </td>
                        <td><span class="total-cell">${fmt(item.price * item.qty)}</span></td>
                    `;
                    tbody.appendChild(tr);
                });

                // Baris kosong (padding)
                const emptyTr = document.createElement("tr");
                emptyTr.className = "empty-row";
                emptyTr.innerHTML = "<td></td><td></td><td></td>";
                tbody.appendChild(emptyTr);

                recalc();
            }

            /* ── Cetak Struk PDF ── */
            function cetakStruk() {
                window.open('/kasir/detail/{{ $pesanan->id_pesanan }}/cetak', '_blank');
            }

            /* ── Init ── */
            renderTable();
        </script>
    </body>
</html>