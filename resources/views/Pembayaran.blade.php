<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Pembayaran</title>
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
            <h1>Pembayaran</h1>
        </div>

        <!-- Order Type -->

        <!-- Informasi Pemesanan -->
        <div class="section" style="padding-top: 20px; padding-bottom: 20px">
            <p class="section-title">Informasi Pemesanan</p>

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <input type="text" id="inputNama" placeholder="" />
                </div>
            </div>

            <div class="form-group">
                <label class="form-label"
                    >Nomor Ponsel (untuk info promo)</label
                >
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 10a19.79 19.79 0 0 1-3-8.57A2 2 0 0 1 3.62 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"
                        />
                    </svg>
                    <input type="tel" id="inputPhone" placeholder="" />
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 0">
                <label class="form-label">Kirim struk ke email</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path
                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                        />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <input type="email" id="inputEmail" placeholder="" />
                </div>
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="section" style="padding-top: 20px; padding-bottom: 16px">
            <p class="section-title">Metode Pembayaran</p>

            <div class="method-grid">
                <div
                    class="method-card active"
                    id="methodOnline"
                    onclick="selectMethod('online')"
                >
                    <div class="method-icon">📱</div>
                    <span class="method-label">Bayar via QRIS</span>
                </div>
                <div
                    class="method-card"
                    id="methodKasir"
                    onclick="selectMethod('kasir')"
                >
                    <div class="method-icon cash">🤝</div>
                    <span class="method-label">Bayar di Kasir</span>
                </div>
            </div>
        </div>

        <div class="divider-line"></div>

        <!-- Bottom Bar -->
        <div class="bottom-bar">
            <div class="total-block">
                <div class="total-label-row">Total Pembayaran</div>
                <span class="total-amount">Rp53.000</span>
            </div>
            <button class="btn-pay" onclick="checkout()">
                Lanjut Pembayaran
            </button>
        </div>



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
        padding-bottom: 120px;
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

    /* Section Title */
    .section-title {
        font-family: "Bebas Neue", cursive;
        font-size: 1.2rem;
        letter-spacing: 2px;
        color: var(--dark);
        margin-bottom: 16px;
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

    /* ── Dividers ── */
    .divider-line {
        height: 2px;
        background: #eee;
        margin: 0 16px;
    }

    /* ── Form ── */
    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 7px;
        display: block;
    }

    .input-wrap {
        display: flex;
        align-items: center;
        border: 2px solid #eee;
        border-radius: 10px;
        background: var(--card-bg);
        padding: 0 14px;
        transition:
            border-color 0.2s,
            box-shadow 0.2s;
    }
    .input-wrap:focus-within {
        border-color: var(--orange);
        box-shadow: 0 0 0 3px rgba(232, 80, 10, 0.15);
    }

    .input-wrap svg {
        width: 18px;
        height: 18px;
        stroke: var(--gray);
        stroke-width: 1.8;
        fill: none;
        flex-shrink: 0;
        margin-right: 10px;
    }

    .input-wrap input {
        flex: 1;
        border: none;
        outline: none;
        font-family: "Nunito", sans-serif;
        font-size: 0.88rem;
        color: var(--text);
        padding: 12px 0;
        background: transparent;
    }
    .input-wrap input::placeholder {
        color: #bbb;
    }

    /* Validation styles */
    .input-wrap.invalid {
        border-color: #e74c3c !important;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2) !important;
    }
    .input-wrap.invalid svg {
        stroke: #e74c3c !important;
    }

    /* ── Payment Method ── */
    .method-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 4px;
    }

    .method-card {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 1.8px solid #eee;
        border-radius: var(--radius);
        padding: 12px 14px;
        cursor: pointer;
        transition:
            border-color 0.2s,
            background 0.2s,
            box-shadow 0.2s;
        background: var(--card-bg);
    }
    .method-card.active {
        border-color: var(--orange);
        background: rgba(232, 80, 10, 0.08);
        box-shadow: 0 0 0 3px rgba(232, 80, 10, 0.15);
    }
    .method-card:hover:not(.active) {
        border-color: #ccc;
        background: var(--cream);
    }

    .method-icon {
        width: 42px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        background: linear-gradient(135deg, #2e6fd9, #5b9bf5);
        flex-shrink: 0;
    }
    .method-icon.cash {
        background: linear-gradient(135deg, #3cb878, #7fd17f);
    }

    .method-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.3;
    }

    /* ── Promo Row ── */
    .promo-row {
        display: flex;
        align-items: center;
        padding: 14px 16px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .promo-row:hover {
        background: var(--cream);
    }
    .promo-row svg {
        width: 20px;
        height: 20px;
        stroke: var(--orange);
        stroke-width: 1.8;
        fill: none;
        margin-right: 10px;
        flex-shrink: 0;
    }
    .promo-text {
        flex: 1;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--orange);
    }
    .promo-arrow {
        font-size: 16px;
        color: var(--gray);
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

    .total-block {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .total-label-row {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray);
        cursor: pointer;
    }
    .total-label-row svg {
        width: 14px;
        height: 14px;
        stroke: var(--gray);
        stroke-width: 2;
        fill: none;
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
        border-radius: 50px;
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

    /* ── Modal Overlay ── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(26, 16, 8, 0.55);
        z-index: 100;
        align-items: flex-end;
        justify-content: center;
    }
    .modal-overlay.open {
        display: flex;
        animation: fadeIn 0.25s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .modal {
        background: var(--card-bg);
        border-radius: 20px 20px 0 0;
        width: 100%;
        max-width: 480px;
        padding: 24px 16px 36px;
        animation: slideUp 0.3s cubic-bezier(0.22, 1, 0.36, 1);
    }
    @keyframes slideUp {
        from {
            transform: translateY(40px);
        }
        to {
            transform: translateY(0);
        }
    }

    .modal-handle {
        width: 36px;
        height: 4px;
        background: #eee;
        border-radius: 2px;
        margin: 0 auto 20px;
    }

    .modal-title {
        font-family: "Bebas Neue", cursive;
        font-size: 1.2rem;
        letter-spacing: 2px;
        color: var(--dark);
        margin-bottom: 16px;
    }

    .modal-option {
        display: flex;
        align-items: center;
        padding: 13px 0;
        border-bottom: 2px solid #eee;
        cursor: pointer;
    }
    .modal-option:last-child {
        border-bottom: none;
    }
    .modal-option-label {
        flex: 1;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--dark);
    }
    .modal-check {
        color: var(--orange);
        font-size: 18px;
        font-weight: 800;
        display: none;
    }
    .modal-option.active .modal-check {
        display: block;
    }

    /* ── Page enter animation ── */
    .header {
        animation: fadeUp 0.3s ease both;
    }
    .section {
        animation: fadeUp 0.4s ease both;
    }
    .divider {
        animation: fadeUp 0.4s ease 0.05s both;
    }
    .method-grid {
        animation: fadeUp 0.4s ease 0.1s both;
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

    document.addEventListener("DOMContentLoaded", () => {
        const totalAmountText = localStorage.getItem("checkout_total") || "Rp0";
        const totalEl = document.querySelector(".total-amount");
        if (totalEl) totalEl.textContent = totalAmountText;
    });


    /* ── Order Type ── */
    function openOrderTypeModal() {
        document.getElementById("orderTypeModal").classList.add("open");
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove("open");
    }
    function setOrderType(label, el) {
        document
            .querySelectorAll("#orderTypeModal .modal-option")
            .forEach((o) => o.classList.remove("active"));
        el.classList.add("active");
        document.getElementById("orderTypeText").textContent = label;
        setTimeout(() => closeModal("orderTypeModal"), 200);
    }

    /* ── Payment Method ── */
    let currentMethod = "online";
    function selectMethod(method) {
        currentMethod = method;
        document
            .getElementById("methodOnline")
            .classList.toggle("active", method === "online");
        document
            .getElementById("methodKasir")
            .classList.toggle("active", method === "kasir");
        document.getElementById("onlineSection").style.display =
            method === "online" ? "" : "none";
        document.getElementById("dividerPromo").style.display =
            method === "online" ? "" : "none";
    }
    
    /* ── Checkout ── */
    async function checkout() {
        // Clear previous invalid states
        document.querySelectorAll('.input-wrap').forEach(wrap => wrap.classList.remove('invalid'));
        
        const nama = document.getElementById("inputNama").value.trim();
        const phone = document.getElementById("inputPhone").value.trim();
        const email = document.getElementById("inputEmail").value.trim();

        if (!nama) {
            showToast("Masukkan nama lengkap");
            return;
        }
        if (!phone) {
            showToast("Masukkan nomor ponsel");
            return;
        }

        // Regex validation
        const phoneRegex = /^(\+62|08)[0-9]{8,13}$/i;
        if (!phoneRegex.test(phone)) {
            showToast("Nomor telepon harus format Indonesia (08xxxxxxxxx atau +62xxxxxxxxx)");
            document.getElementById("inputPhone").parentElement.classList.add('invalid');
            return;
        }

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showToast("Format email tidak valid");
            document.getElementById("inputEmail").parentElement.classList.add('invalid');
            return;
        }

        const totalText = document.querySelector(".total-amount").textContent;
        const amount = totalText.replace(/[^0-9]/g, ''); // email already validated above
        const elOrderType = document.getElementById("orderTypeText");
        const orderType = elOrderType ? elOrderType.textContent.trim() : "Makan di tempat";
        const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
        const catatan = localStorage.getItem("checkout_catatan") || "";

        if (cartItems.length === 0) {
            showToast("Keranjang belanja kosong!");
            return;
        }

        const payload = {
            nama: nama,
            phone: phone,
            email: email,
            orderType: orderType,
            amount: amount,
            paymentMethod: currentMethod,
            cart: cartItems,
            catatan: catatan
        };

        showToast("Sedang memproses pesanan...");

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const response = await fetch('/api/pembayaran/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.success) {
                if (data.method === 'kasir') {
                    // Kasir: hapus cart sekarang karena pesanan sudah masuk DB
                    localStorage.removeItem('cart');
                    localStorage.removeItem('checkout_total');
                    localStorage.removeItem('checkout_catatan');
                    showToast("Pesanan berhasil disimpan! Silakan menuju kasir.");
                    setTimeout(() => {
                        window.location.href = `/menunggu-kasir`;
                    }, 2000);
                } else if (data.method === 'online' || data.qrString) {
                    localStorage.removeItem('cart');
                    localStorage.removeItem('checkout_total');
                    localStorage.removeItem('checkout_catatan');
                    // Berpindah ke view MenungguQris
                    showToast("Mengarahkan ke halaman pembayaran QRIS...");
                    setTimeout(() => {
                        window.location.href = `/menunggu-qris`;
                    }, 1000);
                }
            } else {
                showToast(data.message || "Gagal memproses Checkout, silakan coba lagi");
            }
        } catch (error) {
            console.error(error);
            showToast("Terjadi kesalahan sistem saat memproses checkout.");
        }
    }

    function goBack() {
        window.location.href = "{{ url('/keranjang') }}";
    }

    /* ── Toast ── */
    let toastTimer;
    function showToast(msg) {
        clearTimeout(toastTimer);
        const el = document.getElementById("toast");
        el.textContent = msg;
        el.classList.add("show");
        toastTimer = setTimeout(() => el.classList.remove("show"), 2200);
    }

    /* ── Input validation listeners ── */
    ['inputPhone', 'inputEmail'].forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', () => {
                input.parentElement.classList.remove('invalid');
            });
        }
    });

    /* ── Init Total ── */
    document.addEventListener("DOMContentLoaded", function() {
        const storedTotal = localStorage.getItem("checkout_total");
        if (storedTotal) {
            document.querySelector(".total-amount").textContent = storedTotal;
        } else {
            const params = new URLSearchParams(window.location.search);
            const total = params.get("total");
            if (total) {
                document.querySelector(".total-amount").textContent = total;
            }
        }
    });
</script>
