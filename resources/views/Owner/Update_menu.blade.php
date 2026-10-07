<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update Menu – Admin</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link
      href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap"
      rel="stylesheet"
  />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --orange: #e8500a;
        --orange-bg: #ff6b2b;
        --orange-light: #ff6b2b;
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
        --gray: #888;
    }

    html, body { height: 100%; }

    body {
        font-family: "Nunito", sans-serif;
        background: var(--cream);
        color: var(--text-dark);
        display: flex;
        min-height: 100vh;
    }

    /* ══ SIDEBAR ══ */
    .sidebar {
      width: 240px; min-height: 100vh;
      background: var(--orange-bg);
      display: flex; flex-direction: column;
      align-items: center;
      padding: 36px 20px 28px;
      flex-shrink: 0;
    }
    .avatar {
      width: 96px; height: 96px; border-radius: 50%;
      background: rgba(0,0,0,0.22);
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 14px;
    }
    .avatar svg { width: 58px; height: 58px; fill: rgba(0,0,0,0.55); }
    .sidebar-name { font-size: 17px; font-weight: 700; color: #fff; text-align: center; }
    .sidebar-id {
      font-size: 13.5px; font-weight: 600;
      color: rgba(255,255,255,0.85);
      margin-top: 4px; margin-bottom: 28px; letter-spacing: 0.5px;
    }
    .nav-item {
      display: flex; align-items: center; gap: 10px;
      width: 100%; padding: 11px 14px;
      border-radius: var(--radius);
      cursor: pointer; margin-bottom: 4px;
      font-size: 14.5px; font-weight: 700;
      color: #fff; text-decoration: none;
      transition: background 0.2s;
    }
    .nav-item:hover  { background: rgba(0,0,0,0.12); }
    .nav-item.active { background: rgba(0,0,0,0.20); }
    .nav-item svg { width: 18px; height: 18px; stroke: #fff; stroke-width: 2; fill: none; flex-shrink: 0; }
    .sidebar-footer { margin-top: auto; }
    .btn-logout {
      background: var(--red); color: #fff; border: none;
      border-radius: 20px; padding: 9px 24px;
      font-family: "Nunito", sans-serif; font-size: 14px; font-weight: 700;
      cursor: pointer; transition: background 0.2s, transform 0.15s;
    }
    .btn-logout:hover { background: var(--red-dark); transform: translateY(-2px); }
    .btn-logout:active { transform: scale(0.96); }

    /* ══ MAIN ══ */
    .main { flex: 1; padding: 32px 36px 40px; overflow-y: auto; }
    .page-title {
      font-family: "Bebas Neue", cursive;
      font-size: 42px; font-weight: 400;
      color: var(--text-dark); letter-spacing: 2px; text-transform: uppercase;
      padding-bottom: 10px; border-bottom: 2px solid var(--orange);
      margin-bottom: 28px;
    }

    /* ══ FORM CARD ══ */
    .form-card {
      background: var(--surface);
      border: 2px solid var(--border);
      border-radius: var(--radius);
      box-shadow: 0 4px 15px rgba(0,0,0,0.02);
      padding: 36px;
    }
    .form-group { margin-bottom: 24px; }
    .form-label { display: block; font-size: 13.5px; font-weight: 700; color: var(--text-dark); margin-bottom: 8px; }
    .form-input, .form-textarea {
      width: 100%; border: 1.5px solid var(--border); border-radius: 8px;
      padding: 12px 14px;
      font-family: "Nunito", sans-serif; font-size: 14px; color: var(--text-dark);
      outline: none; background: #fff;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus, .form-textarea:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(232,80,10,0.2);
    }
    .form-textarea { resize: vertical; min-height: 100px; }

    /* Photo upload area */
    .photo-upload {
      border: 2px dashed var(--border); border-radius: 8px;
      padding: 24px; text-align: center; cursor: pointer;
      transition: border-color 0.2s, background 0.2s;
      position: relative;
    }
    .photo-upload:hover { border-color: var(--orange); background: #FFF8EE; }
    .photo-upload input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .photo-upload-icon { font-size: 36px; margin-bottom: 12px; }
    .photo-upload-text { font-size: 14px; color: var(--text-muted); font-weight: 600; }
    .photo-upload-preview {
      width: 120px; height: 120px; border-radius: 12px;
      object-fit: cover; margin: 0 auto 12px; display: block;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* ══ KATEGORI INPUT WITH DROPDOWN ══ */
    .kategori-wrapper {
      position: relative;
    }
    .kategori-wrapper .form-input {
      padding-right: 36px;
      cursor: pointer;
    }
    .kategori-arrow {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      width: 16px; height: 16px;
      stroke: var(--text-muted); stroke-width: 2; fill: none;
      pointer-events: none; transition: transform 0.2s;
    }
    .kategori-dropdown {
      display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 8px; max-height: 220px; overflow-y: auto;
      z-index: 100; box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    .kategori-dropdown.open { display: block; animation: ddFade 0.15s ease; }
    @keyframes ddFade { from{opacity:0;transform:translateY(-6px);} to{opacity:1;transform:translateY(0);} }
    .kategori-dropdown-item {
      padding: 11px 14px; font-size: 13.5px; font-weight: 600;
      color: var(--text-dark); cursor: pointer;
      transition: background 0.12s;
      display: flex; align-items: center; justify-content: space-between;
    }
    .kategori-dropdown-item:hover { background: var(--cream); }
    .kategori-dropdown-item.active { color: var(--orange); }
    .kategori-dropdown-item .check-icon { color: var(--orange); font-size: 14px; }
    .kategori-divider {
      height: 1px; background: var(--border); margin: 4px 0;
    }
    .kategori-new-hint {
      padding: 10px 14px; font-size: 12px; color: var(--text-muted);
      font-style: italic; font-weight: 500;
    }

    /* ══ RESEP TABLE ══ */
    .resep-container {
      background: var(--surface);
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      overflow: visible;
    }
    .resep-table { width: 100%; border-collapse: collapse; }
    .resep-table thead th {
      padding: 12px 20px;
      font-size: 11.5px; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.8px;
      color: var(--text-muted);
      border-bottom: 1.5px solid var(--border);
      text-align: center; background: #FAFAF8;
    }
    .resep-table thead th:first-child { text-align: left; border-radius: var(--radius) 0 0 0; }
    .resep-table thead th:last-child { border-radius: 0 var(--radius) 0 0; }
    .resep-table tbody tr { transition: background 0.15s; }
    .resep-table tbody tr:hover { background: #F5F2EE; }
    .resep-table tbody td {
      padding: 14px 20px;
      font-size: 14px; color: var(--text-dark);
      border-bottom: 1px solid var(--border);
      vertical-align: middle; text-align: center;
    }
    .resep-table tbody tr:last-child td { border-bottom: none; }
    .resep-table tbody td:first-child { text-align: left; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; }
    .resep-table .td-satuan { font-size: 13px; color: var(--text-muted); font-weight: 600; }
    .resep-table .jumlah-input {
      width: 120px; padding: 6px 10px; border: 1.5px solid var(--border);
      border-radius: 8px; font-family: "Nunito", sans-serif;
      font-size: 14px; font-weight: 700; text-align: center;
      color: var(--text-dark); outline: none; background: #fff;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .resep-table .jumlah-input:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(232,80,10,0.2);
    }
    .btn-hapus {
      display: inline-block;
      padding: 5px 16px; border-radius: var(--pill); border: none;
      font-family: "Nunito", sans-serif;
      font-size: 11.5px; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.5px;
      cursor: pointer; color: #fff; background: var(--red);
      transition: filter 0.15s, transform 0.15s;
    }
    .btn-hapus:hover { filter: brightness(1.1); }
    .btn-hapus:active { transform: scale(0.95); }
    .resep-empty {
      text-align: center; padding: 30px 20px;
      color: var(--text-muted); font-size: 14px; font-weight: 600;
    }

    /* ══ SEARCH BAHAN ══ */
    .bahan-search-wrap {
      display: flex; align-items: center;
      border-top: 1.5px solid var(--border);
      padding: 12px 16px; background: #FAFAF8;
      position: relative; border-radius: 0 0 var(--radius) var(--radius);
    }
    .bahan-autocomplete-wrapper { width: 100%; position: relative; }
    .bahan-search-icon {
      position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
      width: 16px; height: 16px; stroke: var(--text-muted); stroke-width: 2; fill: none;
      pointer-events: none;
    }
    .bahan-search-wrap input {
      width: 100%; border: 1.5px solid var(--border); border-radius: 8px;
      padding: 10px 14px 10px 36px;
      font-family: "Nunito", sans-serif; font-size: 13.5px;
      color: var(--text-dark); outline: none; background: #fff;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .bahan-search-wrap input:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(232,80,10,0.2);
    }
    .bahan-search-wrap input::placeholder { color: #C0BCB7; }

    /* Bahan Autocomplete Dropdown */
    .bahan-dropdown {
      display: none; position: absolute; bottom: calc(100% + 6px); left: 0; right: 0;
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 8px;
      max-height: 220px; overflow-y: auto; z-index: 200;
      box-shadow: 0 -8px 24px rgba(0,0,0,0.1);
    }
    .bahan-dropdown.open { display: block; animation: ddFade 0.15s ease; }
    .bahan-dropdown-item {
      padding: 10px 14px; font-size: 13.5px; font-weight: 600;
      color: var(--text-dark); cursor: pointer;
      display: flex; align-items: center; justify-content: space-between;
      transition: background 0.12s;
    }
    .bahan-dropdown-item:hover { background: var(--cream); }
    .bahan-dropdown-item.highlighted { background: rgba(232,80,10,0.08); }
    .bahan-dropdown-item.disabled { opacity: 0.4; pointer-events: none; }
    .bahan-dropdown-item .bahan-satuan { font-size: 11.5px; color: var(--text-muted); font-weight: 500; }
    .bahan-dropdown-empty {
      padding: 14px; text-align: center; font-size: 13px;
      color: var(--text-muted); font-weight: 600;
    }
    .bahan-hint {
      padding: 8px 14px; font-size: 11.5px; color: var(--text-muted);
      font-style: italic; border-top: 1px solid var(--border);
      background: #fafaf8;
    }

    /* Form actions */
    .form-actions {
      display: flex; gap: 14px; margin-top: 32px;
      border-top: 1.5px solid var(--border); padding-top: 24px;
    }
    .btn {
      flex: 1; padding: 12px; border: none; border-radius: 8px;
      font-family: "Nunito", sans-serif; font-size: 14.5px; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.5px;
      cursor: pointer; transition: background 0.2s, transform 0.15s;
      text-align: center; text-decoration: none;
    }
    .btn:active { transform: scale(0.97); }
    .btn-cancel { background: #EEE; color: var(--text-dark); }
    .btn-cancel:hover { background: #E0DCD8; }
    .btn-submit { background: var(--orange); color: #fff; box-shadow: 0 4px 12px rgba(232,80,10,0.25); }
    .btn-submit:hover { background: var(--orange-bg); }

    /* Toast */
    .toast {
      position: fixed; bottom: 28px; left: 50%;
      transform: translateX(-50%) translateY(16px);
      background: #1A1512; color: #fff;
      padding: 11px 22px; border-radius: 100px;
      font-size: 14px; font-weight: 500;
      opacity: 0; pointer-events: none;
      transition: opacity 0.3s, transform 0.3s;
      z-index: 999; white-space: nowrap;
    }
    .toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }

    /* Loading overlay */
    .loading-overlay {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.3); z-index: 500;
      align-items: center; justify-content: center;
    }
    .loading-overlay.show { display: flex; }
    .loading-spinner {
      width: 48px; height: 48px;
      border: 4px solid #fff; border-top-color: var(--orange);
      border-radius: 50%; animation: spin 0.8s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* ══ STATUS TOGGLE ══ */
.status-toggle-group { margin-top: 20px; padding-top: 20px; border-top: 1.5px solid var(--border); }
.btn-toggle-status {
  width: 100%; padding: 12px; border: none; border-radius: 8px;
  font-family: "Nunito", sans-serif; font-size: 14.5px; font-weight: 800;
  text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer;
  transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
  text-align: center;
}
.btn-toggle-status:active { transform: scale(0.97); }
.btn-toggle-status.status-tersedia {
  background: var(--green); color: #fff;
  box-shadow: 0 4px 12px rgba(76,175,80,0.3);
}
.btn-toggle-status.status-tidak {
  background: #ff0000ff; color: #fff;
  box-shadow: none;
}
  </style>
</head>
<body>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar">
  <div class="avatar">
    <svg viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
  </div>
  <p class="sidebar-name">Owner</p>
  <p class="sidebar-id"></p>

  <a class="nav-item" href="/owner/laporan">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    Laporan
  </a>
  <a class="nav-item active" href="/owner/menu">
    <svg viewBox="0 0 24 24">
      <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
      <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
    </svg>
    Mengelola Menu
  </a>
  <a class="nav-item" href="/owner/bahan">
    <svg viewBox="0 0 24 24">
      <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
    </svg>
    Mengelola Stok
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
  <h1 class="page-title">Update Menu</h1>

  <div class="form-card">

    {{-- ── Foto ── --}}
    <div class="form-group">
      <label class="form-label">Foto Menu</label>
      <div class="photo-upload" id="photoUploadArea">
        <input type="file" accept="image/*" id="photoInput" onchange="handlePhoto(event)" />
        @if(!empty($menu['foto']))
          <img id="photoPreview" class="photo-upload-preview" src="{{ $menu['foto'] }}" />
          <div id="photoPlaceholder" style="display:none;">
            <div class="photo-upload-icon">📷</div>
            <div class="photo-upload-text">Klik untuk ganti foto</div>
          </div>
        @else
          <img id="photoPreview" class="photo-upload-preview" style="display:none;" src="" />
          <div id="photoPlaceholder">
            <div class="photo-upload-icon">📷</div>
            <div class="photo-upload-text">Klik untuk upload foto</div>
          </div>
        @endif
      </div>
    </div>

    {{-- ── Nama ── --}}
    <div class="form-group">
      <label class="form-label">Nama Menu</label>
      <input class="form-input" id="inputNama" type="text"
             value="{{ $menu['nama'] ?? '' }}"
             placeholder="cth. Cheese Burger, Beef Burger…" />
    </div>

    {{-- ── Harga ── --}}
    <div class="form-group">
      <label class="form-label">Harga (Rp)</label>
      <input class="form-input" id="inputHarga" type="number" min="0" step="500"
             value="{{ $menu['harga'] ?? '' }}"
             placeholder="cth. 24500" />
    </div>

    {{-- ── Kategori dengan custom dropdown ── --}}
    <div class="form-group">
      <label class="form-label">
        Kategori
        <span style="color:var(--text-muted); font-weight:500; font-size:12px; margin-left:6px;">
        </span>
      </label>
      <div class="kategori-wrapper" id="kategoriWrapper">
        <input
          class="form-input"
          id="inputKategori"
          type="text"
          value="{{ $menu['kategori'] ?? '' }}"
          placeholder="Pilih atau ketik kategori baru..."
          autocomplete="off"
          oninput="onKategoriInput()"
          onfocus="openKategoriDropdown()"
        />
        <svg class="kategori-arrow" id="kategoriArrow" viewBox="0 0 24 24">
          <polyline points="6 9 12 15 18 9"/>
        </svg>
        <div class="kategori-dropdown" id="kategoriDropdown"></div>
      </div>
    </div>

    {{-- ── Bahan Resep ── --}}
    <div class="form-group">
      <label class="form-label">Bahan yang Diperlukan</label>
      <div class="resep-container">
        <table class="resep-table" id="tabelResep">
          <thead>
            <tr>
              <th>Nama Bahan</th>
              <th>Jumlah Digunakan</th>
              <th>Satuan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody id="resepBody"></tbody>
        </table>

        <div class="bahan-search-wrap">
          <div class="bahan-autocomplete-wrapper">
            <svg class="bahan-search-icon" viewBox="0 0 24 24">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input
              type="text"
              id="tagInput"
              placeholder="Cari Bahan dan Tambahkan Bahan Yang Diperlukan"
              autocomplete="off"
              oninput="filterBahan()"
              onfocus="openBahanDropdown()"
              onkeydown="handleBahanKeydown(event)"
            />
            <div class="bahan-dropdown" id="bahanDropdown"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="/owner/menu" class="btn btn-cancel">Batal</a>
      <button class="btn btn-submit" id="btnSubmit" onclick="submitForm()">Simpan Perubahan</button>
    </div>

    {{-- ── Status Ketersediaan Toggle ── --}}
<div class="status-toggle-group">
  <label class="form-label">Status Ketersediaan Menu</label>
  <button type="button" id="btnToggleStatus" onclick="toggleStatus()"></button>
</div>

<!-- Loading overlay -->
<div class="loading-overlay" id="loadingOverlay">
  <div class="loading-spinner"></div>
</div>

<div class="toast" id="toast"></div>

<script>
  /* ── Data dari PHP ── */
  const menuData   = @json($menu);
  const allBahan   = @json($bahanList);
  const allKategori = @json($categories);

  let photoFile = null;
  let highlightedIndex = -1;

  /* Inisialisasi resep dari data menu yang sudah ada */
  let resep = (menuData.bahan || []).map(b => ({
    nama  : b.nama,
    jumlah: Number(b.jumlah) || 1,
    satuan: b.satuan || ''
  }));

  /* ══════════════════════════
     RESEP TABLE
  ══════════════════════════ */
  function renderResep() {
    const tbody = document.getElementById('resepBody');
    tbody.innerHTML = '';

    if (resep.length === 0) {
      tbody.innerHTML = `<tr><td colspan="4">
        <div class="resep-empty">Belum ada bahan ditambahkan. Cari bahan di bawah.</div>
      </td></tr>`;
      return;
    }

    resep.forEach((item, i) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${item.nama}</td>
        <td>
          <input type="number" class="jumlah-input" step="1" min="0"
                 value="${item.jumlah}"
                 onchange="updateJumlah(${i}, this.value)" />
        </td>
        <td class="td-satuan">${item.satuan || '-'}</td>
        <td><button class="btn-hapus" onclick="removeBahan(${i})">Hapus</button></td>
      `;
      tbody.appendChild(tr);
    });
  }

  function addBahanKeResep(nama, satuan) {
    const normNama = nama.trim();
    if (resep.find(b => b.nama.toUpperCase() === normNama.toUpperCase())) {
      showToast(`"${normNama}" sudah ada dalam resep`);
      return;
    }
    resep.push({ nama: normNama, jumlah: 1, satuan: satuan || '' });
    renderResep();
    document.getElementById('tagInput').value = '';
    closeBahanDropdown();
  }

  function removeBahan(i) {
    resep.splice(i, 1);
    renderResep();
    /* refresh dropdown agar tanda ✓ hilang */
    filterBahan();
  }

  function updateJumlah(index, value) {
    resep[index].jumlah = Number(value) || 0;
  }

  /* ══════════════════════════
     BAHAN DROPDOWN
  ══════════════════════════ */
  function getFilteredBahan() {
    const q = document.getElementById('tagInput').value.trim().toLowerCase();
    return allBahan.filter(b => b.nama_bahan.toLowerCase().includes(q));
  }

  function renderBahanDropdown(list) {
    const dropdown = document.getElementById('bahanDropdown');

    if (list.length === 0) {
      dropdown.innerHTML = '<div class="bahan-dropdown-empty">Tidak ada bahan ditemukan</div>';
      dropdown.classList.add('open');
      highlightedIndex = -1;
      return;
    }

    dropdown.innerHTML = list.map((b, idx) => {
      const isSelected = resep.some(r => r.nama.toUpperCase() === b.nama_bahan.toUpperCase());
      return `<div class="bahan-dropdown-item ${isSelected ? 'disabled' : ''}"
                   data-idx="${idx}"
                   data-nama="${b.nama_bahan}"
                   data-satuan="${b.satuan || ''}"
                   onclick="${isSelected ? '' : `addBahanKeResep('${b.nama_bahan.replace(/'/g,"\\'")}','${(b.satuan||'').replace(/'/g,"\\'")}'); return false;`}">
        <span>${b.nama_bahan} ${isSelected ? '<span style="color:var(--green);font-size:12px;">✓ sudah ditambahkan</span>' : ''}</span>
        <span class="bahan-satuan">${b.satuan || ''}</span>
      </div>`;
    }).join('');
    dropdown.classList.add('open');
    highlightedIndex = -1;
  }

  function filterBahan() {
    renderBahanDropdown(getFilteredBahan());
  }

  function openBahanDropdown() {
    renderBahanDropdown(getFilteredBahan());
  }

  function closeBahanDropdown() {
    setTimeout(() => {
      document.getElementById('bahanDropdown').classList.remove('open');
      highlightedIndex = -1;
    }, 150);
  }

  function handleBahanKeydown(e) {
    const dropdown = document.getElementById('bahanDropdown');
    const items    = [...dropdown.querySelectorAll('.bahan-dropdown-item:not(.disabled)')];

    if (e.key === 'ArrowDown') {
      e.preventDefault();
      highlightedIndex = Math.min(highlightedIndex + 1, items.length - 1);
      items.forEach((el, i) => el.classList.toggle('highlighted', i === highlightedIndex));
      items[highlightedIndex]?.scrollIntoView({ block: 'nearest' });

    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      highlightedIndex = Math.max(highlightedIndex - 1, 0);
      items.forEach((el, i) => el.classList.toggle('highlighted', i === highlightedIndex));
      items[highlightedIndex]?.scrollIntoView({ block: 'nearest' });

    } else if (e.key === 'Enter') {
      e.preventDefault();
      if (highlightedIndex >= 0 && items[highlightedIndex]) {
        const el = items[highlightedIndex];
        addBahanKeResep(el.dataset.nama, el.dataset.satuan);
      } else {
        /* Jika tidak ada yang di-highlight, ambil match pertama */
        const filtered = getFilteredBahan();
        const first    = filtered.find(b => !resep.some(r => r.nama.toUpperCase() === b.nama_bahan.toUpperCase()));
        if (first) addBahanKeResep(first.nama_bahan, first.satuan);
      }

    } else if (e.key === 'Escape') {
      document.getElementById('bahanDropdown').classList.remove('open');
    }
  }

  /* ══════════════════════════
     KATEGORI DROPDOWN
  ══════════════════════════ */
  function buildKategoriDropdown(query) {
    const dropdown = document.getElementById('kategoriDropdown');
    const current  = document.getElementById('inputKategori').value.trim();
    const q        = query.toLowerCase();

    /* Semua kategori yang cocok dengan query */
    const matched = allKategori.filter(k => k.toLowerCase().includes(q));

    /* Apakah user mengetik sesuatu yang belum ada di daftar? */
    const isNew = current && !allKategori.some(k => k.toLowerCase() === current.toLowerCase());

    let html = '';

    if (matched.length > 0) {
      html += matched.map(k => {
        const isActive = k.toLowerCase() === current.toLowerCase();
        return `<div class="kategori-dropdown-item ${isActive ? 'active' : ''}"
                     onclick="selectKategori('${k.replace(/'/g,"\\'")}')">
          <span>${k}</span>
          ${isActive ? '<span class="check-icon">✓</span>' : ''}
        </div>`;
      }).join('');
    }

    if (isNew) {
      if (matched.length > 0) html += '<div class="kategori-divider"></div>';
      html += `<div class="kategori-dropdown-item" onclick="selectKategori('${current.replace(/'/g,"\\'")}')">
        <span>Tambah Kategori Baru "<strong>${current}</strong>"</span>
      </div>`;
    }

    dropdown.innerHTML = html;
  }

  function openKategoriDropdown() {
    buildKategoriDropdown(document.getElementById('inputKategori').value);
    document.getElementById('kategoriDropdown').classList.add('open');
    document.getElementById('kategoriArrow').style.transform = 'translateY(-50%) rotate(180deg)';
  }

  function onKategoriInput() {
    buildKategoriDropdown(document.getElementById('inputKategori').value);
    document.getElementById('kategoriDropdown').classList.add('open');
  }

  function selectKategori(value) {
    document.getElementById('inputKategori').value = value;
    document.getElementById('kategoriDropdown').classList.remove('open');
    document.getElementById('kategoriArrow').style.transform = 'translateY(-50%)';
  }

  /* Close kategori dropdown on outside click */
  document.addEventListener('click', (e) => {
    const wrapper = document.getElementById('kategoriWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
      document.getElementById('kategoriDropdown').classList.remove('open');
      document.getElementById('kategoriArrow').style.transform = 'translateY(-50%)';
    }

    const bahanWrapper = document.querySelector('.bahan-autocomplete-wrapper');
    if (bahanWrapper && !bahanWrapper.contains(e.target)) {
      document.getElementById('bahanDropdown').classList.remove('open');
    }
  });

  /* ══════════════════════════
     FOTO
  ══════════════════════════ */
  function handlePhoto(e) {
    const file = e.target.files[0];
    if (!file) return;
    photoFile = file;
    const reader = new FileReader();
    reader.onload = ev => {
      document.getElementById('photoPreview').src = ev.target.result;
      document.getElementById('photoPreview').style.display = 'block';
      document.getElementById('photoPlaceholder').style.display = 'none';
    };
    reader.readAsDataURL(file);
  }

  /* ══════════════════════════
     SUBMIT
  ══════════════════════════ */
  async function submitForm() {
    const btn      = document.getElementById('btnSubmit');
    const nama     = document.getElementById('inputNama').value.trim();
    const harga    = document.getElementById('inputHarga').value;
    const kategori = document.getElementById('inputKategori').value.trim();

    if (!nama)                         { showToast('Masukkan nama menu'); return; }
    if (!harga || parseInt(harga) < 0) { showToast('Masukkan harga yang valid'); return; }
    if (!kategori)                     { showToast('Pilih atau ketik kategori menu'); return; }

    btn.disabled   = true;
    btn.innerText  = 'Menyimpan...';
    document.getElementById('loadingOverlay').classList.add('show');

    const formData = new FormData();
    formData.append('nama_menu', nama.toUpperCase());
    formData.append('harga', harga);
    formData.append('Kategori', kategori);
    formData.append('resep', JSON.stringify(resep));
    formData.append('status', menuStatusValue);
    if (photoFile) formData.append('foto', photoFile);

    try {
      const res  = await fetch(`/owner/menu/${menuData.id}/update`, {
        method : 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept'      : 'application/json'
        },
        body: formData
      });

      const data = await res.json();

      if (data.success) {
        showToast('Perubahan menu berhasil disimpan!');
        setTimeout(() => { window.location.href = '/owner/menu'; }, 1200);
      } else {
        showToast(data.message || 'Gagal menyimpan perubahan');
        btn.disabled  = false;
        btn.innerText = 'Simpan Perubahan';
      }
    } catch (e) {
      console.error(e);
      showToast('Terjadi kesalahan server');
      btn.disabled  = false;
      btn.innerText = 'Simpan Perubahan';
    } finally {
      document.getElementById('loadingOverlay').classList.remove('show');
    }
  }

  /* ══════════════════════════
     TOAST
  ══════════════════════════ */
  let toastTimer;
  function showToast(msg) {
    clearTimeout(toastTimer);
    const el = document.getElementById('toast');
    el.textContent = msg;
    el.classList.add('show');
    toastTimer = setTimeout(() => el.classList.remove('show'), 2400);
  }

  let menuStatusValue = {{ $menu['status'] ? 1 : 0 }};

function toggleStatus() {
  menuStatusValue = menuStatusValue === 1 ? 0 : 1;
  updateStatusBtn();
}

function updateStatusBtn() {
  const btn = document.getElementById('btnToggleStatus');
  if (menuStatusValue === 1) {
    btn.textContent = 'Tersedia';
    btn.className = 'btn-toggle-status status-tersedia';
  } else {
    btn.textContent = 'Tidak Tersedia';
    btn.className = 'btn-toggle-status status-tidak';
  }
}

  /* ── Init ── */
  renderResep();
  updateStatusBtn();



</script>
</body>
</html>