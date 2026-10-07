<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
        />
        <title>Pesanan</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>
    <body>
        <!-- Header -->
        <div class="header">
            <button class="btn-back" onclick="goBack()" aria-label="Kembali">
                <svg viewBox="0 0 24 24" fill="none">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </button>
            <h1>Pesanan</h1>
        </div>

        <!-- Order Items Header -->
        <div class="order-header">
            <span class="order-header-title" id="orderCountTitle"
                >Item yang dipesan (2)</span
            >
            <button
                class="btn-tambah"
                onclick="window.location.href='{{ url('/menu') }}'"
            >
                <svg viewBox="0 0 24 24" fill="none">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                Tambah Item
            </button>
        </div>

        <!-- Order Item List -->
        <div class="order-items" id="orderItems"></div>

        <div class="divider"></div>

        <!-- Global Notes -->
        <div class="section" style="padding-top: 0; padding-bottom: 10px; padding-left: 16px; padding-right: 16px;">
            <p style="font-size: 0.85rem; font-weight: 700; color: var(--dark); margin-bottom: 8px;">Catatan Lainnya</p>
            <textarea id="checkoutCatatan" placeholder="Cth: Jangan pakai kantong plastik, dsb..." style="width: 100%; height: 75px; border: 1.5px solid #eee; border-radius: 12px; padding: 10px 14px; font-family: 'Nunito', sans-serif; font-size: 0.85rem; resize: none; outline: none; transition: border-color 0.2s; background: var(--card-bg);" onfocus="this.style.borderColor='var(--orange)'" onblur="this.style.borderColor='#eee'"></textarea>
        </div>

        <!-- Bottom Bar -->
        <div class="bottom-bar">
            <div class="total-section">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-amount" id="bottomTotal">Rp53.000</span>
            </div>
            <button class="btn-pay" onclick="checkout()">
                Lanjut Pembayaran
            </button>
        </div>

        <div style="height: 120px"></div>
        <!-- Toast -->
        <div class="toast" id="toast"></div>
    </body>
</html>

<!--CSS-->
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
        --radius: 16px;
    }

    body {
        font-family: "Nunito", sans-serif;
        background: var(--cream);
        color: var(--text);
        max-width: 480px;
        margin: 0 auto;
        min-height: 100vh;
        overflow-x: hidden;
    }

    /* ── Header ── */
    .header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        border-bottom: 2px solid #eee;
        top: 0;
        z-index: 10;
        background: var(--card-bg);
    }

    .header h1 {
        font-family: "Bebas Neue", cursive;
        font-size: 1.3rem;
        font-weight: 400;
        color: var(--dark);
        letter-spacing: 2px;
    }

    .btn-back {
        position: absolute;
        left: 14px;
        width: 40px;
        height: 40px;
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition:
            background 0.2s,
            transform 0.2s;
    }
    .btn-back:hover {
        background: var(--cream);
        transform: scale(1.08);
    }
    .btn-back:active {
        transform: scale(0.95);
    }
    .btn-back svg {
        width: 18px;
        height: 18px;
        stroke: var(--dark);
        stroke-width: 2.5;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
    }

    /* ── Sections ── */
    .section {
        padding: 18px 16px 0;
    }

    /* Order Type */
    .order-type-badge {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: rgba(232, 80, 10, 0.08);
        border: 1.8px solid var(--orange);
        border-radius: 50px;
        padding: 12px 18px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .order-type-badge:hover {
        background: rgba(232, 80, 10, 0.14);
    }

    .order-type-left {
        font-size: 0.82rem;
        color: var(--gray);
        font-weight: 600;
    }
    .order-type-right {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--dark);
    }
    .order-type-right svg {
        width: 20px;
        height: 20px;
        stroke: var(--orange);
        stroke-width: 2.2;
        fill: none;
    }

    /* Section Title */
    .section-title {
        font-family: "Bebas Neue", cursive;
        font-size: 1.2rem;
        letter-spacing: 2px;
        color: var(--dark);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title::after {
        content: "";
        flex: 1;
        height: 3px;
        background: linear-gradient(to right, var(--orange), transparent);
        border-radius: 3px;
    }

    /* ── Order Items ── */
    .order-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 16px 0;
    }

    .order-header-title {
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--dark);
    }

    .btn-tambah {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border: 1.8px solid var(--orange);
        background: transparent;
        border-radius: 8px;
        font-family: "Nunito", sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--orange);
        cursor: pointer;
        transition:
            background 0.2s,
            color 0.2s,
            transform 0.1s;
    }
    .btn-tambah:hover {
        background: var(--orange);
        color: white;
    }
    .btn-tambah:hover svg {
        stroke: white;
    }
    .btn-tambah:active {
        transform: scale(0.96);
    }
    .btn-tambah svg {
        width: 14px;
        height: 14px;
        stroke: var(--orange);
        stroke-width: 2.5;
        stroke-linecap: round;
        fill: none;
    }

    /* Order Item Row */
    .order-items {
        padding: 0 16px;
    }

    .order-item {
        padding: 16px 0;
        border-bottom: 2px solid #eee;
    }
    .order-item:last-child {
        border-bottom: none;
    }

    .item-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .item-name {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--dark);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .item-qty {
        font-size: 0.8rem;
        color: var(--gray);
        margin-top: 3px;
        font-weight: 600;
    }

    .item-note {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 5px;
        font-size: 0.78rem;
        color: var(--gray);
        font-style: italic;
    }
    .item-note svg {
        width: 14px;
        height: 14px;
        stroke: var(--gray);
        stroke-width: 1.8;
        flex-shrink: 0;
        fill: none;
    }

    .item-price {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--orange);
        margin-top: 8px;
    }

    .btn-ubah {
        display: flex;
        align-items: center;
        gap: 5px;
        background: none;
        border: none;
        font-family: "Nunito", sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--gray);
        cursor: pointer;
        transition: color 0.2s;
        flex-shrink: 0;
    }
    .btn-ubah:hover {
        color: var(--orange);
    }
    .btn-ubah svg {
        width: 13px;
        height: 13px;
        stroke: currentColor;
        stroke-width: 2;
        fill: none;
    }

    .divider {
        height: 3px;
        background: linear-gradient(var(--orange), transparent);
        border-radius: 3px;
        margin: 18px 22px;
    }

    /* ── Bottom Bar ── */
    .bottom-bar {
        position: fixed;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 480px;
        background: var(--card-bg);
        border-top: 2px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px calc(14px + env(safe-area-inset-bottom));
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        z-index: 50;
    }

    .total-section {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .total-label {
        font-size: 0.75rem;
        color: var(--gray);
        font-weight: 600;
    }
    .total-amount {
        font-size: 1.2rem;
        font-weight: 800;
        color: var(--dark);
    }

    .btn-pay {
        padding: 14px 22px;
        background: var(--orange);
        color: #fff;
        border: none;
        border-radius: 30px;
        font-family: "Nunito", sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 6px 30px rgba(232, 80, 10, 0.4);
        transition:
            transform 0.15s,
            box-shadow 0.15s,
            background 0.2s;
        white-space: nowrap;
    }
    .btn-pay:hover {
        background: var(--orange-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(232, 80, 10, 0.5);
    }
    .btn-pay:active {
        transform: scale(0.96);
    }

    /* ── Page enter animation ── */
    .header {
        animation: fadeUp 0.3s ease both;
    }
    .section {
        animation: fadeUp 0.4s ease both;
    }
    .order-header {
        animation: fadeUp 0.4s ease 0.05s both;
    }
    .order-items {
        animation: fadeUp 0.4s ease 0.1s both;
    }
    .divider {
        animation: fadeUp 0.4s ease 0.12s both;
    }
    .payment-box {
        animation: fadeUp 0.4s ease 0.15s both;
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

    /* Toast */
    .toast {
        position: fixed;
        top: 16px;
        left: 50%;
        transform: translateX(-50%) translateY(-80px);
        background: var(--dark);
        color: white;
        border-radius: 30px;
        padding: 10px 22px;
        font-size: 0.88rem;
        font-weight: 600;
        z-index: 200;
        transition: transform 0.35s cubic-bezier(0.77, 0, 0.18, 1);
        white-space: nowrap;
    }
    .toast.show {
        transform: translateX(-50%) translateY(0);
    }
</style>

<!--Javascript-->
<script>
    // ── State ──
    let rawCart = JSON.parse(localStorage.getItem("cart")) || [];
    let orders = rawCart.map((o) => ({
        ...o,
        note: o.notes || o.note || "",
    }));

    // ── Render ──
    function fmt(n) {
        return (
            "Rp" +
            n.toLocaleString("id-ID").replace(/\./g, ".").replace(",", ".")
        );
    }

    function renderOrders() {
        const container = document.getElementById("orderItems");
        container.innerHTML = "";

        if (orders.length === 0) {
            container.innerHTML =
                "<p style='text-align:center; padding: 20px; color: var(--gray); font-size: 0.9rem;'>Keranjang masih kosong.</p>";
            updateTotals();
            return;
        }

        orders.forEach((item, i) => {
            const div = document.createElement("div");
            div.className = "order-item";
            div.innerHTML = `
        <div class="item-top">
          <div>
            <p class="item-name">${item.name}</p>
            <p class="item-qty">${item.qty}x</p>
          </div>
          <div style="display: flex; gap: 12px; align-items: center;">
            <button class="btn-ubah" onclick="window.location.href='{{ url('/detail-menu') }}/${item.id}?edit=${i}'">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/>
              </svg>
              Ubah
            </button>
            <button class="btn-ubah" style="color: #e8500a;" onclick="hapusPesanan(${i})">
              <svg viewBox="0 0 24 24" fill="none" stroke="#e8500a">
                <polyline points="3 6 5 6 21 6"></polyline>
                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
              </svg>
              Hapus
            </button>
          </div>
        </div>
        <div class="item-note" style="${item.note ? "" : "display:none;"}">
          <svg viewBox="0 0 24 24" fill="none">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
          </svg>
          ${item.note}
        </div>
        <p class="item-price">${fmt(item.price)}</p>
      `;
            container.appendChild(div);
        });

        updateTotals();
    }

    function updateTotals() {
        const total = orders.reduce((s, o) => s + o.price, 0);

        const elBottomTotal = document.getElementById("bottomTotal");
        if (elBottomTotal) elBottomTotal.textContent = fmt(total);

        const elOrderCount = document.getElementById("orderCountTitle");
        const totalQty = orders.reduce((s, o) => s + o.qty, 0);
        if (elOrderCount) elOrderCount.textContent = `Item yang dipesan (${totalQty})`;
    }

    // ── Actions ──
    function hapusPesanan(index) {
        const item = orders[index];
        {
            orders.splice(index, 1);
            localStorage.setItem("cart", JSON.stringify(orders));
            renderOrders();
            showToast(`${item.name} dihapus dari pesanan`, true);
        }
    }

    function addRelated(name, price) {
        const existing = orders.find((o) => o.name === name);
        if (existing) {
            existing.qty++;
        } else {
            orders.push({ name, qty: 1, price, note: "" });
        }
        renderOrders();
        showToast(`${name} ditambahkan`);
    }

    function toggleFee(e) {
        e.stopPropagation();
        const detail = document.getElementById("feeDetail");
        const arrow = document.getElementById("feeToggle");
        const open = detail.style.display === "none";
        detail.style.display = open ? "flex" : "none";
        arrow.textContent = open ? "▲" : "▼";
    }

    function checkout() {
        const t = document.getElementById("bottomTotal").textContent;
        localStorage.setItem("checkout_total", t);
        const catatan = document.getElementById("checkoutCatatan") ? document.getElementById("checkoutCatatan").value : "";
        localStorage.setItem("checkout_catatan", catatan);
        window.location.href = "{{ url('/pembayaran') }}";
    }

    function goBack() {
        window.location.href = "{{ url('/menu') }}";
    }

    function showToast(msg, isWarning = false) {
        const el = document.getElementById("toast");
        el.textContent = msg;
        if (isWarning) {
            el.style.background = "#e8500a"; // Merah/Orange peringatan
        } else {
            el.style.background = "var(--dark)";
        }
        el.classList.add("show");
        setTimeout(() => el.classList.remove("show"), 2200);
    }

    // Init
    renderOrders();
</script>
