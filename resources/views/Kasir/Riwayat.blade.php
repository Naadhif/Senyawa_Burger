<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Pesanan Selesai – Kasir</title>
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
                --orange-bg: #ff6b2b;
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
            }

            html,
            body {
                height: 100%;
            }

            body {
                font-family: "Nunito", sans-serif;
                background: var(--cream);
                display: flex;
                min-height: 100vh;
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
                font-size: 17px;
                font-weight: 700;
                color: #fff;
                text-align: center;
                margin-bottom: 28px;
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
            }
            .nav-item.active {
                background: rgba(0, 0, 0, 0.18);
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

            /* ══ TOOLBAR ══ */
            .toolbar {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 18px;
            }

            .search-wrap {
                flex: 1;
                max-width: 320px;
                display: flex;
                align-items: center;
                border: 1.5px solid var(--border);
                border-radius: var(--radius);
                background: #fff;
                padding: 0 12px;
                transition: border-color 0.2s;
            }
            .search-wrap:focus-within {
                border-color: var(--orange);
            }
            .search-wrap svg {
                width: 16px;
                height: 16px;
                stroke: var(--text-muted);
                stroke-width: 2;
                fill: none;
                margin-right: 8px;
                flex-shrink: 0;
            }
            .search-wrap input {
                flex: 1;
                border: none;
                outline: none;
                font-family: "Nunito", sans-serif;
                font-size: 13.5px;
                color: var(--text-dark);
                padding: 9px 0;
                background: transparent;
            }
            .search-wrap input::placeholder {
                color: #c0bcb7;
            }

            /* ══ TABLE CARD ══ */
            .table-card {
                background: var(--surface);
                border: 2px solid var(--border);
                border-radius: var(--radius);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
                overflow: hidden;
            }

            .table-card-header {
                padding: 15px 20px;
                font-size: 15px;
                font-weight: 800;
                color: var(--text-dark);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-bottom: 1.5px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .table-count {
                font-size: 13px;
                font-weight: 500;
                color: var(--text-muted);
            }

            /* Table */
            .queue-table {
                width: 100%;
                border-collapse: collapse;
            }

            .queue-table thead th {
                padding: 12px 20px;
                font-size: 11.5px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: var(--text-muted);
                border-bottom: 1.5px solid var(--border);
                text-align: left;
                background: #fafaf8;
            }

            .queue-table thead th:not(:first-child) {
                text-align: center;
            }

            .queue-table tbody tr {
                transition: background 0.15s;
            }
            .queue-table tbody tr:hover {
                background: #f5f2ee;
            }

            .queue-table tbody td {
                padding: 16px 20px;
                font-size: 14px;
                color: var(--text-dark);
                border-bottom: 1px solid var(--border);
                vertical-align: middle;
            }
            .queue-table tbody tr:last-child td {
                border-bottom: none;
            }
            .queue-table tbody td:not(:first-child) {
                text-align: center;
            }

            .td-name {
                font-weight: 600;
            }

            /* Badges */
            .badge {
                display: inline-block;
                padding: 5px 14px;
                border-radius: var(--pill);
                font-size: 12px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                cursor: default;
            }

            /* Tambahan warna badge untuk Selesai */
            .badge-selesai {
                background: #2196F3;
                color: #fff;
            }

            /* Aksi */
            .btn-lihat {
                display: inline-block;
                padding: 6px 18px;
                border-radius: var(--pill);
                background: var(--green);
                color: #fff;
                border: none;
                font-family: "Nunito", sans-serif;
                font-size: 12.5px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.4px;
                cursor: pointer;
                transition: background 0.2s, transform 0.15s;
            }
            .btn-lihat:hover {
                background: var(--green-dark);
                box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
                transform: translateY(-2px);
            }
            .btn-lihat:active {
                transform: scale(0.95);
            }

            /* Empty state */
            .empty-state {
                text-align: center;
                padding: 60px 20px;
                color: var(--text-muted);
            }
            .empty-state .empty-icon {
                font-size: 48px;
                margin-bottom: 12px;
            }
            .empty-state p {
                font-size: 15px;
            }

            /* Pagination */
            .pagination {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 6px;
                padding: 14px 20px;
                border-top: 1px solid var(--border);
            }

            .page-btn {
                width: 32px;
                height: 32px;
                border: 1.5px solid var(--border);
                border-radius: 6px;
                background: #fff;
                font-family: "Nunito", sans-serif;
                font-size: 13px;
                font-weight: 600;
                color: var(--text-dark);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: background 0.15s, border-color 0.15s;
            }
            .page-btn:hover:not([disabled]) {
                border-color: var(--orange);
                color: var(--orange);
            }
            .page-btn.active {
                background: var(--orange);
                border-color: var(--orange);
                color: #fff;
            }
            .page-btn[disabled] {
                opacity: 0.5;
                cursor: not-allowed;
            }
            .page-btn svg {
                width: 14px;
                height: 14px;
                stroke: currentColor;
                stroke-width: 2;
                fill: none;
            }
        </style>
    </head>

    <body>
        <aside class="sidebar">
            <div class="avatar">
                <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
            </div>
            <p class="sidebar-name">Kasir</p>

            <a class="nav-item" href="/kasir/antrian">
                <svg viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="18" x2="21" y2="18" /></svg>
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
            <h1 class="page-title">Pesanan Selesai</h1>

            <div class="toolbar">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8" /><line x1="21" y1="21" x2="16.65" y2="16.65" /></svg>
                    <input type="text" id="searchInput" placeholder="Cari nama pelanggan…" oninput="filterTable()" />
                </div>
            </div>

            <div class="table-card">
                <div class="table-card-header">
                    Daftar Riwayat Pesanan
                    <span class="table-count" id="tableCount">0 pesanan</span>
                </div>

                <table class="queue-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jumlah Pesanan</th>
                            <th>Total Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="queueBody">
                        </tbody>
                </table>
                <div class="pagination" id="pagination"></div>
            </div>
        </main>

        <script>
            let queue = {!! json_encode($queue) !!};
            let filtered = [...queue];
            const PER_PAGE = 10;
            let page = 1;

            function fmt(n) {
                return "Rp" + parseInt(n || 0).toLocaleString("id-ID");
            }

            function filterTable() {
                const q = document.getElementById("searchInput").value.toLowerCase();
                filtered = queue.filter(r => r.nama.toLowerCase().includes(q));
                page = 1;
                render();
            }

            function render() {
                const tbody = document.getElementById("queueBody");
                tbody.innerHTML = "";

                const start = (page - 1) * PER_PAGE;
                const slice = filtered.slice(start, start + PER_PAGE);

                if (slice.length === 0) {
                    tbody.innerHTML = `<tr><td colspan="5"><div class="empty-state"><div class="empty-icon">📋</div><p>Tidak ada riwayat ditemukan</p></div></td></tr>`;
                } else {
                    slice.forEach((row) => {
                        const tr = document.createElement("tr");
                        tr.innerHTML = `
                            <td class="td-name">${row.nama}</td>
                            <td>${row.jumlah}</td>
                            <td>${fmt(row.total)}</td>
                            <td><span class="badge badge-selesai">SELESAI</span></td>
                            <td>
                                <a class="btn-lihat" href="/kasir/riwayat/detail/${row.id}" style="text-decoration:none;">LIHAT</a>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
                document.getElementById("tableCount").textContent = `${filtered.length} pesanan`;
                renderPagination();
            }

            function renderPagination() {
                const total = Math.ceil(filtered.length / PER_PAGE);
                const pg = document.getElementById("pagination");
                if (total <= 1) { pg.innerHTML = ""; return; }

                let html = `<button class="page-btn" onclick="changePage(${page - 1})" ${page === 1 ? "disabled" : ""}><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></button>`;
                for (let i = 1; i <= total; i++) {
                    html += `<button class="page-btn ${i === page ? "active" : ""}" onclick="changePage(${i})">${i}</button>`;
                }
                html += `<button class="page-btn" onclick="changePage(${page + 1})" ${page === total ? "disabled" : ""}><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>`;
                pg.innerHTML = html;
            }

            function changePage(p) {
                const total = Math.ceil(filtered.length / PER_PAGE);
                if (p < 1 || p > total) return;
                page = p;
                render();
            }

            render();
        </script>
    </body>
</html>