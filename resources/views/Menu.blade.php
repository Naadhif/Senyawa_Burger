<!doctype html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Senyawa Burger</title>
        <link
            href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap"
            rel="stylesheet"
        />
    </head>

    <body>
        <!-- HERO -->
        <div class="hero">
            <img class="picSen" src="{{ asset('senyawa.png') }}" alt="senyawa">
            </div>
        </div>

        <!-- SEARCH OVERLAY -->
        <div class="search-overlay" id="searchOverlay">
            <div class="search-box">
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Cari menu..."
                    autocomplete="off"
                />
            </div>
        </div>

        <!-- CATEGORY TABS -->
        <nav class="tabs">
            @foreach ($kategoriList as $index => $kat)
                <button class="tab-btn {{ $index === 0 ? 'active' : '' }}" data-tab="{{ $kat }}">
                    {{ strtoupper($kat) }}
                </button>
            @endforeach
        </nav>

        <!-- MENU SECTIONS (dari database) -->
        @foreach ($kategoriList as $kat)
            @if (isset($menus[$kat]) && $menus[$kat]->count() > 0)
                <section class="section" id="tab-{{ $kat }}">
                    <h2 class="section-title">{{ strtoupper($kat) }}</h2>
                    <div class="menu-grid" id="grid-{{ $kat }}">
                        @foreach ($menus[$kat] as $index => $item)
                            <div class="menu-card" style="animation-delay: {{ $index * 0.07 }}s">
                                <img
                                    class="card-img"
                                    src="{{ $item->foto ? 'data:image/jpeg;base64,' . base64_encode($item->foto) : asset('default.png') }}"
                                    alt="{{ $item->nama_menu }}"
                                    loading="lazy"
                                />
                                <div class="card-body">
                                    <div class="card-name">{{ $item->nama_menu }}</div>
                                    <div class="card-price">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                                    <button
                                        class="btn-tambah"
                                        data-id="{{ $item->id_menu }}"
                                    >
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach

        <!-- CART BAR -->
        <div class="cart-bar" id="cartBar" onclick="window.location.href='{{ url('/keranjang') }}'">
            <span>Lihat Pesanan</span>
            <div class="cart-badge" id="cartCount">0</div>
            <span id="cartTotal">Rp0</span>
        </div>

        <!-- TOAST -->
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

    /* ── HERO ── */
    .hero {
        position: relative;
        width: 100%;
        height: 150px;
        overflow: hidden;
        background: var(--dark);
    }

    .hero img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.85;
    }

    .hero-search {
        position: absolute;
        top: 14px;
        right: 14px;
        background: white;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
        transition: transform 0.2s;
    }
    .hero-search:hover {
        transform: scale(1.08);
    }
    .hero-search svg {
        width: 18px;
        stroke: var(--dark);
        fill: none;
        stroke-width: 2.5;
        stroke-linecap: round;
    }

    /* ── SEARCH OVERLAY ── */
    .search-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(26, 16, 8, 0.55);
        z-index: 100;
        align-items: flex-start;
        justify-content: center;
        padding-top: 60px;
    }
    .search-overlay.open {
        display: flex;
    }
    .search-box {
        background: white;
        border-radius: var(--radius);
        padding: 16px;
        width: 90%;
        max-width: 420px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.25s ease;
    }
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .search-box input {
        width: 100%;
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 10px 14px;
        font-family: inherit;
        font-size: 1rem;
        outline: none;
        transition: border 0.2s;
    }
    .search-box input:focus {
        border-color: var(--orange);
    }

    /* ── TABS ── */
    .tabs {
        display: flex;
        background: white;
        border-bottom: 2px solid #eee;
        position: sticky;
        top: 0;
        z-index: 10;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
    }

    .tabs::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
    }

    .tab-btn {
        flex: 0 0 calc(100% / 3); /* selalu tampil 3 tombol */
        min-width: calc(100% / 3);
        scroll-snap-align: start;
        background: none;
        border: none;
        padding: 14px 0 12px;
        font-family: "Bebas Neue", cursive;
        font-size: 1.05rem;
        letter-spacing: 1.5px;
        color: #999;
        cursor: pointer;
        position: relative;
        transition: color 0.2s;
    }

    .tab-btn.active {
        color: var(--orange);
        border-bottom: 3px solid var(--orange);
    }

    /* ── SECTION ── */
    .section {
        display: block;
        padding: 20px 16px 32px;
    }
    /* last section gets bottom padding for cart bar */
    .section:last-of-type {
        padding-bottom: 100px;
    }

    .section-title {
        font-family: "Bebas Neue", cursive;
        font-size: 1.4rem;
        letter-spacing: 2px;
        color: var(--dark);
        margin-bottom: 18px;
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

    /* ── GRID ── */
    .menu-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .menu-card {
        background: var(--card-bg);
        border-radius: var(--radius);
        overflow: hidden;
        transition:
            transform 0.2s,
            box-shadow 0.2s;
        animation: fadeUp 0.4s ease both;
    }

    .menu-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(232, 80, 10, 0.15);
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

    .menu-card:nth-child(1) {
        animation-delay: 0.05s;
    }
    .menu-card:nth-child(2) {
        animation-delay: 0.12s;
    }
    .menu-card:nth-child(3) {
        animation-delay: 0.19s;
    }
    .menu-card:nth-child(4) {
        animation-delay: 0.26s;
    }

    .card-img {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        display: block;
    }

    .card-body {
        padding: 10px 12px 14px;
    }

    .card-name {
        font-weight: 800;
        font-size: 0.82rem;
        line-height: 1.3;
        min-height: 2.2em;
        color: var(--dark);
    }

    .card-price {
        color: var(--dark);
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 6px;
    }

    .btn-tambah {
        width: 100%;
        background: white;
        border: 1.8px solid var(--orange);
        color: var(--orange);
        border-radius: 8px;
        padding: 7px 0;
        font-family: "Nunito", sans-serif;
        font-weight: 700;
        font-size: 0.88rem;
        cursor: pointer;
        transition:
            background 0.2s,
            color 0.2s,
            transform 0.1s;
        position: relative;
        overflow: hidden;
    }

    .btn-tambah:hover {
        background: var(--orange);
        color: white;
    }

    .btn-tambah:active {
        transform: scale(0.96);
    }

    .btn-tambah.added {
        background: var(--orange);
        color: white;
    }

    /* ── CART BAR ── */
    .cart-bar {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(80px);
        background: var(--orange);
        color: white;
        border-radius: 50px;
        padding: 14px 28px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 6px 30px rgba(232, 80, 10, 0.4);
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: transform 0.4s cubic-bezier(0.77, 0, 0.18, 1);
        z-index: 50;
        width: max-content;
        max-width: 90vw;
    }

    .cart-bar.show {
        transform: translateX(-50%) translateY(0);
    }

    .cart-badge {
        background: white;
        color: var(--orange);
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 800;
    }

    /* ── TOAST ── */
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
    // ── FORMAT HARGA ──
    function fmt(n) {
        return "Rp" + Number(n).toLocaleString("id-ID");
    }

    // ── TABS — click scrolls to section ──
    const tabsNav = document.querySelector(".tabs");

    document.querySelectorAll(".tab-btn").forEach((btn) => {
        btn.addEventListener("click", () => {
            // Hapus active dari semua tombol
            document
                .querySelectorAll(".tab-btn")
                .forEach((b) => b.classList.remove("active"));
            btn.classList.add("active");

            // Scroll navbar agar tombol aktif terlihat di tengah
            const btnLeft = btn.offsetLeft;
            const btnWidth = btn.offsetWidth;
            const navWidth = tabsNav.offsetWidth;
            tabsNav.scrollTo({
                left: btnLeft - navWidth / 2 + btnWidth / 2,
                behavior: "smooth",
            });

            // Scroll halaman ke section
            const target = document.getElementById("tab-" + btn.dataset.tab);
            if (!target) return;
            const offset = tabsNav.offsetHeight;
            const top =
                target.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: "smooth" });
        });
    });

    // ── SCROLL SPY — highlight active tab while scrolling ──
    const sections = document.querySelectorAll(".section");

    function setActiveTab(id) {
        document.querySelectorAll(".tab-btn").forEach((b) => {
            b.classList.toggle("active", b.dataset.tab === id);
        });
    }

    if (sections.length > 0) {
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        setActiveTab(entry.target.id.replace("tab-", ""));
                    }
                });
            },
            {
                root: null,
                rootMargin: `-${document.querySelector(".tabs").offsetHeight}px 0px -55% 0px`,
                threshold: 0,
            },
        );

        sections.forEach((s) => observer.observe(s));
    }

    // ── TOMBOL TAMBAH → ke halaman Detail ──
    document.body.addEventListener("click", (e) => {
        if (!e.target.matches(".btn-tambah")) return;
        const btn = e.target;
        const id = btn.dataset.id;
        if (id) {
            window.location.href = "{{ url('/detail-menu') }}/" + id;
        }
    });

    // ── CART ──
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartBar = document.getElementById("cartBar");
    const cartCount = document.getElementById("cartCount");
    const cartTotal = document.getElementById("cartTotal");

    function updateCart() {
        const total = cart.reduce((s, i) => s + i.price, 0);
        const totalQty = cart.reduce((s, i) => s + i.qty, 0);
        cartCount.textContent = totalQty;
        cartTotal.textContent = fmt(total);
        cartBar.classList.toggle("show", cart.length > 0);
    }

    // Inisialisasi cart saat halaman dimuat
    updateCart();

    // ── TOAST ──
    const toastEl = document.getElementById("toast");
    let toastTimer;
    function showToast(msg) {
        toastEl.textContent = msg;
        toastEl.classList.add("show");
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => toastEl.classList.remove("show"), 2000);
    }

    // ── SEARCH ──
    const overlay = document.getElementById("searchOverlay");
    const input = document.getElementById("searchInput");

    const searchBtn = document.getElementById("searchBtn");
    if (searchBtn) {
        searchBtn.addEventListener("click", () => {
            overlay.classList.add("open");
            input.value = "";
            input.focus();
        });
    }

    overlay.addEventListener("click", (e) => {
        if (e.target === overlay) overlay.classList.remove("open");
    });

    input.addEventListener("input", () => {
        const q = input.value.toLowerCase().trim();
        if (!q) return;
        // Cari menu card yang cocok
        const allCards = document.querySelectorAll(".menu-card");
        for (const card of allCards) {
            const name = card.querySelector(".card-name").textContent.toLowerCase();
            if (name.includes(q)) {
                overlay.classList.remove("open");
                const section = card.closest(".section");
                if (section) {
                    const offset = tabsNav.offsetHeight;
                    const top = section.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: "smooth" });
                }
                break;
            }
        }
    });
</script>
