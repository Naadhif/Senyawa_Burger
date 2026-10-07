<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Daftar Antrian – Kasir</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>

    <body>
        <!-- ═══ SIDEBAR ═══ -->
        <aside class="sidebar">
            <div class="avatar">
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"
                    />
                </svg>
            </div>
            <p class="sidebar-name">Kasir</p>
            <p class="sidebar-id"></p>

            <a class="nav-item active" href="/kasir/antrian">
                <svg viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
                Daftar Antrian
            </a>

            <a class="nav-item" href="/kasir/riwayat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Pesanan Selesai
            </a>

            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </aside>

        <!-- ═══ MAIN ═══ -->
        <main class="main">
            <h1 class="page-title">Daftar Antrian</h1>

            <!-- Toolbar -->
            <div class="toolbar">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari nama pelanggan…"
                        oninput="filterTable()"
                    />
                </div>
                <select
                    class="filter-select"
                    id="filterStatus"
                    onchange="filterTable()"
                >
                    <option value="">Semua Status</option>
                    <option value="lunas">Lunas</option>
                    <option value="belum">Belum Lunas</option>
                </select>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <div class="table-card-header">
                    Daftar Antrian
                    <span class="table-count" id="tableCount">1 antrian</span>
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
                        <!-- filled by JS -->
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination" id="pagination"></div>
            </div>
        </main>

        <!-- ═══ DETAIL MODAL ═══ -->
        <div class="modal-overlay" id="detailModal">
            <div class="modal">
                <div class="modal-header">
                    <p class="modal-title" id="modalCustomer">Detail Pesanan</p>
                    <button class="btn-close" onclick="closeModal()">✕</button>
                </div>
                <div id="modalRows"></div>
                <div class="modal-actions">
                    <button class="modal-btn cancel" onclick="closeModal()">
                        Tutup
                    </button>
                    <button
                        class="modal-btn confirm"
                        onclick="konfirmasiLunas()"
                    >
                        Konfirmasi Lunas
                    </button>
                </div>
            </div>
        </div>

        <div class="toast" id="toast"></div>
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
        transition:
            background 0.2s,
            transform 0.15s;
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

    .filter-select {
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        background: #fff;
        padding: 9px 12px;
        font-family: "Nunito", sans-serif;
        font-size: 13.5px;
        color: var(--text-dark);
        outline: none;
        cursor: pointer;
        transition: border-color 0.2s;
    }
    .filter-select:focus {
        border-color: var(--orange);
    }

    .btn-add {
        background: var(--orange);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 9px 18px;
        font-family: "Nunito", sans-serif;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 7px;
        transition:
            background 0.2s,
            transform 0.15s;
        margin-left: auto;
    }
    .btn-add:hover {
        background: var(--orange-bg);
        box-shadow: 0 4px 12px rgba(232, 80, 10, 0.3);
        transform: translateY(-2px);
    }
    .btn-add:active {
        transform: scale(0.97);
    }
    .btn-add svg {
        width: 15px;
        height: 15px;
        stroke: #fff;
        stroke-width: 2.5;
        fill: none;
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
        cursor: pointer;
        transition:
            transform 0.15s,
            filter 0.15s;
    }
    .badge:hover {
        filter: brightness(1.1);
    }
    .badge:active {
        transform: scale(0.95);
    }

    .badge-lunas {
        background: var(--green);
        color: #fff;
    }
    .badge-belum {
        background: var(--red);
        color: #fff;
    }
    .badge-proses {
        background: #f0a500;
        color: #fff;
    }

    .badge-stack {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
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
        transition:
            background 0.2s,
            transform 0.15s;
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
        transition:
            background 0.15s,
            border-color 0.15s;
    }
    .page-btn:hover {
        border-color: var(--orange);
        color: var(--orange);
    }
    .page-btn.active {
        background: var(--orange);
        border-color: var(--orange);
        color: #fff;
    }
    .page-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
    }

    /* ══ DETAIL MODAL ══ */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 200;
        align-items: center;
        justify-content: center;
    }
    .modal-overlay.open {
        display: flex;
        animation: mfade 0.2s ease;
    }
    @keyframes mfade {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .modal {
        background: #fff;
        border-radius: 18px;
        padding: 28px 28px 24px;
        max-width: 480px;
        width: 92%;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        animation: mslide 0.25s cubic-bezier(0.22, 1, 0.36, 1);
    }
    @keyframes mslide {
        from {
            transform: scale(0.92);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .modal-title {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-dark);
    }
    .btn-close {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 22px;
        color: var(--text-muted);
        line-height: 1;
        transition: color 0.2s;
    }
    .btn-close:hover {
        color: var(--text-dark);
    }

    .modal-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
        font-size: 14px;
    }
    .modal-row:last-of-type {
        border-bottom: none;
    }
    .modal-row-label {
        color: var(--text-muted);
        font-weight: 500;
    }
    .modal-row-val {
        font-weight: 700;
        color: var(--text-dark);
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        margin-top: 22px;
    }
    .modal-btn {
        flex: 1;
        padding: 11px;
        border: none;
        border-radius: 8px;
        font-family: "Nunito", sans-serif;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }
    .modal-btn.cancel {
        background: #eee;
        color: var(--text-dark);
    }
    .modal-btn.cancel:hover {
        background: #ddd;
    }
    .modal-btn.confirm {
        background: var(--green);
        color: #fff;
    }
    .modal-btn.confirm:hover {
        background: var(--green-dark);
    }

    /* ══ TOAST ══ */
    .toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%) translateY(16px);
        background: #1a1512;
        color: #fff;
        padding: 11px 22px;
        border-radius: 100px;
        font-size: 14px;
        font-weight: 500;
        opacity: 0;
        pointer-events: none;
        transition:
            opacity 0.3s,
            transform 0.3s;
        z-index: 999;
        white-space: nowrap;
    }
    .toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
</style>

<!--Javascript-->
<script>
    /* ── Data ── */
    let queue = {!! json_encode($queue) !!};

    let filtered = [...queue];
    let currentRow = null;
    const PER_PAGE = 10;
    let page = 1;

    /* ── Format ── */
    function fmt(n) {
        return "Rp" + parseInt(n || 0).toLocaleString("id-ID");
    }

    /* ── Status badge ── */
    function statusBadge(row) {
        const map = {
            lunas: `<span class="badge badge-lunas">LUNAS</span>`,
            belum: `<span class="badge badge-belum">BELUM LUNAS</span>`,
        };
        return map[row.status] || "";
    }

    /* ── Filter & Render ── */
    function filterTable() {
        const q = document.getElementById("searchInput").value.toLowerCase();
        const s = document.getElementById("filterStatus").value;
        filtered = queue.filter(
            (r) =>
                r.nama.toLowerCase().includes(q) &&
                (s === "" || r.status === s),
        );
        page = 1;
        render();
    }

    function applyFilter() {
        const q = document.getElementById("searchInput").value.toLowerCase();
        const s = document.getElementById("filterStatus").value;
        filtered = queue.filter(
            (r) =>
                r.nama.toLowerCase().includes(q) &&
                (s === "" || r.status === s),
        );
        render();
    }

    function render() {
        const tbody = document.getElementById("queueBody");
        tbody.innerHTML = "";

        const start = (page - 1) * PER_PAGE;
        const slice = filtered.slice(start, start + PER_PAGE);

        if (slice.length === 0) {
            tbody.innerHTML = `
        <tr><td colspan="5">
        <div class="empty-state">
            <div class="empty-icon">📋</div>
            <p>Tidak ada antrian ditemukan</p>
        </div>
        </td></tr>`;
        } else {
            slice.forEach((row) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
            <td class="td-name">${row.nama}</td>
            <td>${row.jumlah}</td>
            <td>${fmt(row.total)}</td>
            <td>
            <div class="badge-stack">
                ${statusBadge(row)}
            </div>
            </td>
        <td>
            <a class="btn-lihat" href="/kasir/detail/${row.id}" style="text-decoration:none;">LIHAT</a>
        </td>
        `;
                tbody.appendChild(tr);
            });
        }

        // Count
        document.getElementById("tableCount").textContent =
            `${filtered.length} antrian`;

        renderPagination();
    }

    /* ── Pagination ── */
    function renderPagination() {
        const total = Math.ceil(filtered.length / PER_PAGE);
        const pg = document.getElementById("pagination");
        if (total <= 1) {
            pg.innerHTML = "";
            return;
        }

        let html = `<button class="page-btn" onclick="changePage(${page - 1})" ${page === 1 ? "disabled" : ""}>
        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    </button>`;
        for (let i = 1; i <= total; i++) {
            html += `<button class="page-btn ${i === page ? "active" : ""}" onclick="changePage(${i})">${i}</button>`;
        }
        html += `<button class="page-btn" onclick="changePage(${page + 1})" ${page === total ? "disabled" : ""}>
        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
    </button>`;
        pg.innerHTML = html;
    }

    function changePage(p) {
        const total = Math.ceil(filtered.length / PER_PAGE);
        if (p < 1 || p > total) return;
        page = p;
        render();
    }

    /* ── Detail Modal ── */
    function openDetail(id) {
        currentRow = queue.find((r) => r.id === id);
        if (!currentRow) return;

        document.getElementById("modalCustomer").textContent =
            `Detail – ${currentRow.nama}`;
        document.getElementById("modalRows").innerHTML = `
        <div class="modal-row"><span class="modal-row-label">Nama</span><span class="modal-row-val">${currentRow.nama}</span></div>
        <div class="modal-row"><span class="modal-row-label">Menu</span><span class="modal-row-val">${currentRow.menu}</span></div>
        <div class="modal-row"><span class="modal-row-label">Jumlah</span><span class="modal-row-val">${currentRow.jumlah}</span></div>
        <div class="modal-row"><span class="modal-row-label">Total</span><span class="modal-row-val">${fmt(currentRow.total)}</span></div>
        <div class="modal-row"><span class="modal-row-label">Status</span><span class="modal-row-val">${currentRow.status.toUpperCase()}</span></div>
    `;
        document.getElementById("detailModal").classList.add("open");
    }

    function closeModal() {
        document.getElementById("detailModal").classList.remove("open");
        currentRow = null;
    }

    document.getElementById("detailModal").addEventListener("click", (e) => {
        if (e.target === document.getElementById("detailModal")) closeModal();
    });

    function konfirmasiLunas() {
        if (!currentRow) return;
        currentRow.status = "lunas";
        closeModal();
        applyFilter();
        showToast(`✅ ${currentRow ? currentRow.nama : ""} dikonfirmasi lunas`);
    }

    /* ── Add Dummy ── */
    let counter = queue.length + 1;
    const dummyNames = [
        "Andi",
        "Lina",
        "Bowo",
        "Nisa",
        "Fajar",
        "Putri",
        "Hendra",
    ];
    const dummyMenus = [
        "Beef Burger",
        "Cheese Burger",
        "Chicken Burger",
        "Fish Burger",
    ];
    const dummyStatus = ["lunas", "belum"];

    function addDummy() {
        const name = dummyNames[Math.floor(Math.random() * dummyNames.length)];
        const menu = dummyMenus[Math.floor(Math.random() * dummyMenus.length)];
        const qty = Math.floor(Math.random() * 8) + 1;
        const price = [22000, 24500, 26000, 28000][
            Math.floor(Math.random() * 4)
        ];
        queue.push({
            id: counter++,
            nama: name,
            jumlah: qty,
            total: qty * price,
            status: dummyStatus[Math.floor(Math.random() * 3)],
            menu,
        });
        applyFilter();
        showToast(`➕ ${name} ditambahkan ke antrian`);
    }

    /* ── Toast ── */
    let toastTimer;
    function showToast(msg) {
        clearTimeout(toastTimer);
        const el = document.getElementById("toast");
        el.textContent = msg;
        el.classList.add("show");
        toastTimer = setTimeout(() => el.classList.remove("show"), 2400);
    }

    /* ── Init ── */
    filtered = [...queue];
    render();
</script>
