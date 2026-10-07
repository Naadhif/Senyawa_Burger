<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0"
        />
        <title>{{ $menu->nama_menu }} – Detail Pesanan</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>

    <body>
        <!-- Hero -->
        <div class="hero">
            <img
                src="{{ $menu->foto ? 'data:image/jpeg;base64,' . base64_encode($menu->foto) : asset('default.png') }}"
                alt="{{ $menu->nama_menu }}"
                id="heroImg"
            />
            <div class="hero-overlay"></div>
            <button class="btn-back" onclick="goBack()" aria-label="Kembali">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <polyline points="15 18 9 12 15 6" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="body">
            <h1 class="product-name">{{ $menu->nama_menu }}</h1>
            <p class="product-price" id="priceDisplay">Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>

            <div class="divider"></div>

            <!-- Sesuaikan Pesanan -->
            <div class="modifiers-section">
                <p class="section-label">Sesuaikan Pesanan</p>

                @if($menu->bahan && $menu->bahan->count() > 0)
                    <p class="modifier-group-title">Kurangi/Hilangkan:</p>
                    @foreach($menu->bahan as $bahan)
                        <label class="modifier-item">
                            <input
                                type="checkbox"
                                class="modifier-checkbox"
                                data-type="remove"
                                value="{{ $bahan->nama_bahan }}"
                            />
                            <span class="custom-check"></span>
                            <span>Tanpa {{ ucwords(strtolower($bahan->nama_bahan)) }}</span>
                        </label>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="bottom-bar">
            <div class="quantity-row">
                <span class="quantity-label">Jumlah Pesanan</span>
                <div class="quantity-controls">
                    <button
                        class="qty-btn"
                        id="btnMinus"
                        onclick="changeQty(-1)"
                        aria-label="Kurangi"
                    >
                        <svg viewBox="0 0 24 24" fill="none">
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </button>
                    <span class="qty-value" id="qtyDisplay">1</span>
                    <button
                        class="qty-btn"
                        onclick="changeQty(1)"
                        aria-label="Tambah"
                    >
                        <svg viewBox="0 0 24 24" fill="none">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </button>
                </div>
            </div>

            <button class="btn-order" id="btnOrder" onclick="addToCart(event)">
                Tambah Pesanan – <span class="btn-price" id="btnPrice">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
            </button>
        </div>

        <!-- Toast -->
        <div class="toast" id="toast">Ditambahkan ke pesanan!</div>
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
        min-height: auto;
        overflow-x: hidden;
    }

    /* ── Hero Image ── */
    .hero {
        position: relative;
        width: 100%;
        height: 270px;
        overflow: hidden;
        background: var(--dark);
    }

    .hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        opacity: 0.85;
        transition: transform 0.4s ease;
    }

    .hero:hover img {
        transform: scale(1.03);
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.18) 0%,
            transparent 40%,
            transparent 60%,
            rgba(0, 0, 0, 0.25) 100%
        );
    }

    /* Back Button */
    .btn-back {
        position: absolute;
        top: 14px;
        left: 14px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.92);
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
        transition:
            background 0.2s,
            transform 0.2s;
        z-index: 10;
    }

    .btn-back:hover {
        background: #fff;
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

    /* ── Content Body ── */
    .body {
        padding: 20px 16px 120px;
    }

    .product-name {
        font-family: "Bebas Neue", cursive;
        font-size: 1.8rem;
        color: var(--dark);
        line-height: 1.2;
        letter-spacing: 2px;
    }

    .product-price {
        font-size: 1rem;
        font-weight: 700;
        color: var(--orange);
        margin-top: 6px;
    }

    .divider {
        height: 3px;
        background: linear-gradient(var(--orange), transparent);
        border-radius: 3px;
        margin: 18px 0;
    }

    /* ── Modifiers Section ── */
    .modifiers-section {
        margin-bottom: 4px;
    }

    .modifier-group-title {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--dark);
        margin-top: 12px;
        margin-bottom: 10px;
    }

    .modifier-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text);
        cursor: pointer;
        transition: color 0.2s;
    }

    .modifier-item:hover {
        color: var(--orange);
    }

    .modifier-item input[type="checkbox"] {
        display: none;
    }

    .custom-check {
        width: 22px;
        height: 22px;
        border: 2px solid #ccc;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition:
            border-color 0.2s,
            background 0.2s;
    }

    .modifier-item input[type="checkbox"]:checked + .custom-check {
        background: var(--orange);
        border-color: var(--orange);
    }

    .modifier-item input[type="checkbox"]:checked + .custom-check::after {
        content: "✓";
        color: #fff;
        font-size: 0.75rem;
        font-weight: 800;
    }

    /* ── Notes Section ── */
    .section-label {
        font-size: 0.88rem;
        font-weight: 800;
        color: var(--dark);
        margin-bottom: 2px;
    }

    .section-sublabel {
        font-size: 0.78rem;
        color: var(--gray);
        margin-bottom: 12px;
    }

    .notes-area {
        width: 100%;
        min-height: 110px;
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 10px 14px;
        font-family: "Nunito", sans-serif;
        font-size: 0.88rem;
        color: var(--text);
        background: var(--card-bg);
        resize: vertical;
        transition:
            border-color 0.2s,
            box-shadow 0.2s;
        outline: none;
    }

    .notes-area::placeholder {
        color: #bbb;
    }

    .notes-area:focus {
        border-color: var(--orange);
        box-shadow: 0 0 0 3px rgba(232, 80, 10, 0.15);
    }

    /* ── Bottom Bar ── */
    .bottom-bar {
        bottom: 0;
        width: 100%;
        max-width: 480px;
        padding: 10px 16px calc(16px + env(safe-area-inset-bottom));
        position: fixed;
        background-color: #f5f0eb;
    }

    .quantity-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        order: 2;
        margin-top: 3px;
        margin-bottom: 10px;
    }

    .quantity-label {
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--dark);
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .qty-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1.8px solid var(--orange);
        background: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition:
            background 0.2s,
            color 0.2s,
            transform 0.1s;
    }

    .qty-btn:hover {
        background: var(--orange);
    }
    .qty-btn:hover svg {
        stroke: #fff;
    }
    .qty-btn:active {
        transform: scale(0.9);
    }
    .qty-btn svg {
        width: 16px;
        height: 16px;
        stroke: var(--orange);
        stroke-width: 2.5;
        stroke-linecap: round;
    }

    .qty-value {
        font-family: "Bebas Neue", cursive;
        font-size: 1.3rem;
        color: var(--dark);
        min-width: 20px;
        text-align: center;
        letter-spacing: 1px;
        transition: transform 0.15s;
    }

    .qty-value.bump {
        animation: bump 0.2s ease;
    }

    @keyframes bump {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.35);
        }
        100% {
            transform: scale(1);
        }
    }

    /* CTA Button */
    .btn-order {
        width: 100%;
        padding: 14px;
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
        position: relative;
        overflow: hidden;
    }

    .btn-order:hover {
        background: var(--orange-light);
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(232, 80, 10, 0.5);
    }

    .btn-order:active {
        transform: scale(0.96);
        box-shadow: 0 2px 10px rgba(232, 80, 10, 0.3);
    }

    /* ripple */
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.35);
        transform: scale(0);
        animation: ripple-anim 0.5s linear;
        pointer-events: none;
    }

    @keyframes ripple-anim {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    /* ── Page enter animation ── */
    .body {
        animation: fadeUp 0.4s ease both;
    }
    .bottom-bar {
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
    const paramName = @json($menu->nama_menu);
    const paramPrice = @json((int) $menu->harga);

    document.title = paramName + " – Detail Pesanan";

    const BASE_PRICE = paramPrice;
    let qty = 1;

    function formatRupiah(n) {
        return "Rp" + n.toLocaleString("id-ID").replace(/\./g, ".");
    }

    function getAddonTotal() {
        let total = 0;
        document
            .querySelectorAll('.modifier-checkbox[data-type="addon"]:checked')
            .forEach((cb) => {
                total += parseInt(cb.dataset.price) || 0;
            });
        return total;
    }

    function updatePrice() {
        const unitPrice = BASE_PRICE + getAddonTotal();
        const total = unitPrice * qty;
        document.getElementById("priceDisplay").textContent =
            formatRupiah(unitPrice);
        document.getElementById("btnPrice").textContent = formatRupiah(total);
    }

    function changeQty(delta) {
        const next = qty + delta;
        if (next < 1) return;
        qty = next;

        const el = document.getElementById("qtyDisplay");
        el.textContent = qty;
        el.classList.remove("bump");
        void el.offsetWidth;
        el.classList.add("bump");

        updatePrice();
        document.getElementById("btnMinus").style.opacity =
            qty === 1 ? "0.4" : "1";
    }

    // checkbox listeners
    const allRemoveCheckboxes = document.querySelectorAll('.modifier-checkbox[data-type="remove"]');
    document.querySelectorAll(".modifier-checkbox").forEach((cb) => {
        cb.addEventListener("change", function() {
            if (this.dataset.type === 'remove') {
                const checkedCount = document.querySelectorAll('.modifier-checkbox[data-type="remove"]:checked').length;
                if (checkedCount === allRemoveCheckboxes.length && allRemoveCheckboxes.length > 0) {
                    this.checked = false;
                    showToast("Tidak bisa menghilangkan semua bahan!");
                    return;
                }
            }
            updatePrice();
        });
    });

    function addToCart(e) {
        // Ripple effect
        const btn = document.getElementById("btnOrder");
        const rect = btn.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        const ripple = document.createElement("span");
        ripple.className = "ripple";
        ripple.style.cssText = `width:${size}px;height:${size}px;left:${x}px;top:${y}px`;
        btn.appendChild(ripple);
        setTimeout(() => ripple.remove(), 600);

        const unitPrice = BASE_PRICE + getAddonTotal();
        const removedItems = [];
        document.querySelectorAll('.modifier-checkbox[data-type="remove"]:checked').forEach((cb) => {
            removedItems.push(cb.value);
        });

        const orderItem = {
            id: @json($menu->id_menu),
            name: paramName,
            price: unitPrice * qty,
            qty: qty,
            notes: removedItems.length > 0 ? "Tanpa " + removedItems.join(", ") : ""
        };

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        const urlParams = new URLSearchParams(window.location.search);
        const editIndex = urlParams.get('edit');
        
        if (editIndex !== null && cart[editIndex]) {
            cart[editIndex] = orderItem;
            showToast("Pesanan diperbarui!");
        } else {
            cart.push(orderItem);
            showToast("Ditambahkan ke pesanan!");
        }

        let newCart = [];
        cart.forEach(item => {
            let existing = newCart.find(x => x.id === item.id && x.notes === item.notes);
            if (existing) {
                existing.qty += item.qty;
                existing.price += item.price;
            } else {
                newCart.push(item);
            }
        });
        localStorage.setItem('cart', JSON.stringify(newCart));

        setTimeout(() => {
            window.location.href = editIndex !== null ? "{{ url('/keranjang') }}" : "{{ url('/menu') }}";
        }, 100);
    }

    let toastTimer;
    function showToast(message) {
        const t = document.getElementById("toast");
        if (message) {
            t.textContent = message;
        } else {
            t.textContent = "Ditambahkan ke pesanan!";
        }
        t.classList.add("show");
        setTimeout(() => t.classList.remove("show"), 2200);
    }

    function goBack() {
        window.location.href = "{{ url('/menu') }}";
    }

    // Init
    document.getElementById("btnMinus").style.opacity = "0.4";
    
    const urlParams = new URLSearchParams(window.location.search);
    const editIndex = urlParams.get('edit');
    if (editIndex !== null) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart[editIndex]) {
            const item = cart[editIndex];
            qty = item.qty;
            document.getElementById("qtyDisplay").textContent = qty;
            if (qty > 1) {
                document.getElementById("btnMinus").style.opacity = "1";
            }
            if (item.notes) {
                const removedStr = item.notes.replace("Tanpa ", "");
                const removedArr = removedStr.split(", ");
                document.querySelectorAll('.modifier-checkbox[data-type="remove"]').forEach((cb) => {
                    if (removedArr.includes(cb.value)) {
                        cb.checked = true;
                    }
                });
            }
            document.getElementById("btnOrder").innerHTML = `Update Pesanan – <span class="btn-price" id="btnPrice"></span>`;
        }
    }

    updatePrice();
</script>
