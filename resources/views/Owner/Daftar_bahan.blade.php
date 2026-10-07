<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Bahan – Admin</title>
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
        --purple: #7B61FF;
        --purple-dark: #6348E0;
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
      width: 96px; height: 96px;
      border-radius: 50%;
      background: rgba(0,0,0,0.22);
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 14px;
    }
    .avatar svg { width: 58px; height: 58px; fill: rgba(0,0,0,0.55); }

    .sidebar-name {
      font-size: 17px; font-weight: 700;
      color: #fff; text-align: center;
    }
    .sidebar-id {
      font-size: 13.5px; font-weight: 600;
      color: rgba(255,255,255,0.85);
      margin-top: 4px; margin-bottom: 28px;
      letter-spacing: 0.5px;
    }

    .nav-item {
      display: flex; align-items: center; gap: 10px;
      width: 100%; padding: 11px 14px;
      border-radius: var(--radius);
      cursor: pointer;
      font-size: 15px; font-weight: 700;
      color: #fff;
      text-decoration: none;
      transition: background 0.2s;
      margin-bottom: 4px;
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
      width: 18px; height: 18px;
      stroke: #fff; stroke-width: 2;
      fill: none; flex-shrink: 0;
    }

    .sidebar-footer { margin-top: auto; }

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
    .btn-logout:active { transform: scale(0.96); }

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
      border-bottom: 1.5px solid var(--border);
      display: flex; align-items: center; justify-content: space-between;
    }

    .table-card-title {
        font-family: "Nunito", sans-serif;
        font-size: 15px;
        font-weight: 800;
        color: var(--text-dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* CREATE button */
    .btn-create {
      background: var(--orange);
      color: #fff; border: none;
      border-radius: var(--pill);
      padding: 8px 20px;
      font-family: "Nunito", sans-serif;
      font-size: 13px; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.5px;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s, box-shadow 0.15s;
      box-shadow: 0 4px 12px rgba(232, 80, 10, 0.3);
      margin-left: auto;
    }
    .btn-create:hover  { background: var(--orange-bg); box-shadow: 0 4px 12px rgba(232, 80, 10, 0.3); transform: translateY(-2px); }
    .btn-create:active { transform: scale(0.96); }


    .search-wrap {
      display: flex; align-items: center;
      border: 1.5px solid var(--border);
      border-radius: var(--radius);
      background: #fff; padding: 0 12px;
      flex: 1; max-width: 300px;
      transition: border-color 0.2s;
    }
    .search-wrap:focus-within { border-color: var(--orange); }
    .search-wrap svg { width: 16px; height: 16px; stroke: var(--text-muted); stroke-width: 2; fill:none; margin-right: 8px; flex-shrink:0; }
    .search-wrap input {
      flex:1; border:none; outline:none;
      font-family: "Nunito", sans-serif;
      font-size:13.5px; color:var(--text-dark);
      padding: 9px 0; background:transparent;
    }
    .search-wrap input::placeholder { color:#C0BCB7; }

    /* Table */
    .bahan-table { width: 100%; border-collapse: collapse; }

    .bahan-table thead th {
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
    .bahan-table thead th:not(:first-child) { text-align: center; }

    .bahan-table tbody tr { transition: background 0.15s; }
    .bahan-table tbody tr:hover { background: #F5F2EE; }

    .bahan-table tbody td {
        padding: 16px 20px;
        font-family: "Nunito", sans-serif;
        font-size: 14px;
        color: var(--text-dark);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    .bahan-table tbody tr:last-child td { border-bottom: none; }
    .bahan-table tbody td:not(:first-child) { text-align: center; }

    .td-name { font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px; }

    /* Stock badge */
    .stock-low  { color: var(--red);   font-weight: 700; }
    .stock-ok   { color: var(--green); font-weight: 700; }

    /* Action buttons */
    .action-btns { display: flex; flex-direction: column; align-items: center; gap: 7px; }

    .btn-action {
      display: inline-block;
      padding: 6px 18px;
      border-radius: var(--pill);
      border: none;
      font-family: "Nunito", sans-serif;
      font-size: 12px; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.5px;
      cursor: pointer;
      transition: filter 0.15s, transform 0.15s, box-shadow 0.2s;
      min-width: 80px;
    }
    .btn-action:hover  { filter: brightness(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.1); transform: translateY(-2px); }
    .btn-action:active { transform: scale(0.95); }

    .btn-update { background: var(--green); color: #fff; }
    .btn-delete { background: var(--red);   color: #fff; }

    /* Empty state */
    .empty-state {
      text-align: center; padding: 60px 20px;
      color: var(--text-muted);
    }
    .empty-icon { font-size: 44px; margin-bottom: 12px; }

    /* Pagination */
    .pagination {
      display: flex; align-items: center; justify-content: flex-end;
      gap: 6px; padding: 14px 20px;
      border-top: 1px solid var(--border);
    }
    .page-btn {
      width: 32px; height: 32px;
      border: 1.5px solid var(--border);
      border-radius: 6px; background: #fff;
      font-family: "Nunito", sans-serif;
      font-size:13px; font-weight:600;
      color: var(--text-dark); cursor: pointer;
      display:flex; align-items:center; justify-content:center;
      transition: background 0.15s, border-color 0.15s;
    }
    .page-btn:hover  { border-color: var(--orange); color: var(--orange); }
    .page-btn.active { background: var(--orange); border-color: var(--orange); color: #fff; }
    .page-btn svg { width:14px; height:14px; stroke:currentColor; stroke-width:2; fill:none; }

    /* ══ SATUAN DROPDOWN ══ */
.satuan-wrapper { position: relative; }
.satuan-wrapper .form-input { padding-right: 36px; cursor: pointer; }
.satuan-arrow {
  position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
  width: 16px; height: 16px;
  stroke: var(--text-muted); stroke-width: 2; fill: none;
  pointer-events: none; transition: transform 0.2s;
}
.satuan-dropdown {
  display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
  background: #fff; border: 1.5px solid var(--border);
  border-radius: 8px; max-height: 220px; overflow-y: auto;
  z-index: 300; box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}
.satuan-dropdown.open { display: block; animation: ddFade 0.15s ease; }
@keyframes ddFade { from{opacity:0;transform:translateY(-6px);} to{opacity:1;transform:translateY(0);} }
.satuan-dropdown-item {
  padding: 11px 14px; font-size: 13.5px; font-weight: 600;
  color: var(--text-dark); cursor: pointer;
  display: flex; align-items: center; justify-content: space-between;
  transition: background 0.12s;
}
.satuan-dropdown-item:hover { background: var(--cream); }
.satuan-dropdown-item.active { color: var(--orange); }
.satuan-dropdown-item .check-icon { color: var(--orange); font-size: 14px; }
.satuan-divider { height: 1px; background: var(--border); margin: 4px 0; }
.satuan-new-hint {
  padding: 10px 14px; font-size: 12px; color: var(--text-muted);
  font-style: italic; font-weight: 500;
}

    /* ══ MODAL ══ */
    .modal-overlay {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.45); z-index: 200;
      align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; animation: mfade 0.2s ease; }
    @keyframes mfade { from{opacity:0;} to{opacity:1;} }

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
      from { transform:scale(0.92);opacity:0; }
      to   { transform:scale(1);   opacity:1; }
    }

    .modal-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 20px;
    }
    .modal-title { font-size: 18px; font-weight: 800; color: var(--text-dark); }
    .btn-close {
      background:none; border:none; cursor:pointer;
      font-size:22px; color:var(--text-muted);
      transition: color 0.2s; line-height:1;
    }
    .btn-close:hover { color: var(--text-dark); }

    .form-group { margin-bottom: 16px; text-align: left; }
    .form-label {
      display:block; font-size:13.5px; font-weight:600;
      color:var(--text-dark); margin-bottom:7px;
    }
    .form-input {
      width:100%; border: 1.5px solid var(--border);
      border-radius: var(--radius);
      padding: 10px 13px;
      font-family: "Nunito", sans-serif;
      font-size:14px; color:var(--text-dark);
      outline:none; background:#fff;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(232,80,10,0.2);
    }

    .modal-actions { display:flex; gap:10px; margin-top:22px; }
    .modal-btn {
      flex:1; padding:11px;
      border:none; border-radius:8px;
      font-family: "Nunito", sans-serif;
      font-size:14px; font-weight:700;
      cursor:pointer; transition:background 0.2s;
    }
    .modal-btn.cancel  { background:#EEE; color:var(--text-dark); }
    .modal-btn.cancel:hover  { background:#DDD; }
    .modal-btn.submit  { background:var(--orange); color:#fff; }
    .modal-btn.submit:hover  { background:var(--orange-bg); }
    .modal-btn.danger  { background:var(--red); color:#fff; }
    .modal-btn.danger:hover  { background:var(--red-dark); }

    /* ══ TOAST ══ */
    .toast {
      position:fixed; bottom:28px; left:50%;
      transform:translateX(-50%) translateY(16px);
      background:#1A1512; color:#fff;
      padding:11px 22px; border-radius:100px;
      font-size:14px; font-weight:500;
      opacity:0; pointer-events:none;
      transition:opacity 0.3s, transform 0.3s;
      z-index:999; white-space:nowrap;
    }
    .toast.show { opacity:1; transform:translateX(-50%) translateY(0); }
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
  <a class="nav-item" href="/owner/menu" onclick="showToast('Mengelola Menu')">
    <svg viewBox="0 0 24 24">
      <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
      <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
    </svg>
    Mengelola Menu
  </a>
  <a class="nav-item active" href="/owner/bahan">
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
  <h1 class="page-title">Daftar Bahan</h1>

  <!-- Toolbar -->
  <div class="toolbar">
    <div class="search-wrap">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="searchInput" placeholder="Cari nama bahan…" oninput="filterData()" />
    </div>
    <button class="btn-create" onclick="openCreateModal()">CREATE BAHAN</button>
  </div>

  <div class="table-card">
    <!-- Header -->
    <div class="table-card-header">
      <span class="table-card-title"></span>
    </div>

    <!-- Table -->
    <table class="bahan-table">
      <thead>
        <tr>
          <th>Nama Bahan</th>
          <th>Jumlah</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="bahanBody"></tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination" id="pagination"></div>
  </div>
</main>

<!-- ═══ CREATE / EDIT MODAL ═══ -->
<div class="modal-overlay" id="formModal">
  <div class="modal">
    <div class="modal-header">
      <p class="modal-title" id="formModalTitle">Tambah Bahan</p>
      <button class="btn-close" onclick="closeModal('formModal')">✕</button>
    </div>
    <div class="form-group">
      <label class="form-label">Nama Bahan</label>
      <input class="form-input" id="inputNama" type="text" placeholder="cth. Roti, Daging, Keju…" />
    </div>
    <div class="form-group">
      <label class="form-label">Jumlah</label>
      <input class="form-input" id="inputJumlah" type="number" min="0" placeholder="0" />
    </div>
    <div class="form-group">
      <label class="form-label">Satuan</label>
      <div class="satuan-wrapper" id="satuanWrapper">
        <input
          class="form-input"
          id="inputSatuan"
          type="text"
          placeholder="Pilih atau ketik satuan..."
          autocomplete="off"
          oninput="onSatuanInput()"
          onfocus="openSatuanDropdown()"
        />
        <svg class="satuan-arrow" id="satuanArrow" viewBox="0 0 24 24">
          <polyline points="6 9 12 15 18 9"/>
        </svg>
        <div class="satuan-dropdown" id="satuanDropdown"></div>
      </div>
    </div>
    <div class="modal-actions">
      <button class="modal-btn cancel" onclick="closeModal('formModal')">Batal</button>
      <button class="modal-btn submit" id="formSubmitBtn" onclick="submitForm()">Simpan</button>
    </div>
  </div>
</div>

<!-- ═══ DELETE CONFIRM MODAL ═══ -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal" style="max-width:360px; text-align:center;">
    <div style="font-size:44px; margin-bottom:12px;"></div>
    <p class="modal-title" style="margin-bottom:8px;">Hapus Bahan?</p>
    <p style="font-size:14px; color:var(--text-muted); margin-bottom:22px;" id="deleteModalBody">
      Tindakan ini tidak dapat dibatalkan.
    </p>
    <div class="modal-actions">
      <button class="modal-btn cancel" onclick="closeModal('deleteModal')">Batal</button>
      <button class="modal-btn danger" onclick="confirmDelete()">Ya, Hapus</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
  /* ── State ── */
  let items = @json($bahan);

  let filtered    = [...items];
  let editId      = null;
  let deleteId    = null;
  const PER_PAGE  = 8;
  let page        = 1;

  /* ── Render ── */
  function render() {
    const tbody = document.getElementById('bahanBody');
    tbody.innerHTML = '';

    const start = (page - 1) * PER_PAGE;
    const slice = filtered.slice(start, start + PER_PAGE);

    if (!slice.length) {
      tbody.innerHTML = `<tr><td colspan="3">
        <div class="empty-state">
          <div class="empty-icon"></div>
          <p>Tidak ada bahan ditemukan</p>
        </div></td></tr>`;
    } else {
      slice.forEach(item => {
        const jumlahNum = Number(item.jumlah);
        const low = jumlahNum <= 3;
        const tr  = document.createElement('tr');
        tr.innerHTML = `
          <td class="td-name">${item.nama}</td>
          <td class="${low ? 'stock-low' : 'stock-ok'}">${jumlahNum} ${item.satuan}</td>
          <td>
            <div class="action-btns">
              <button class="btn-action btn-update" onclick="openEditModal(${item.id})">UPDATE</button>
              <button class="btn-action btn-delete" onclick="openDeleteModal(${item.id})">DELETE</button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    renderPagination();
  }

  function filterData() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    filtered = items.filter(i => i.nama.toLowerCase().includes(q));
    page = 1;
    render();
  }

  /* ── Pagination ── */
  function renderPagination() {
    const total = Math.ceil(filtered.length / PER_PAGE);
    const pg    = document.getElementById('pagination');
    if (total <= 1) { pg.innerHTML = ''; return; }

    let html = `<button class="page-btn" onclick="changePage(${page-1})" ${page===1?'disabled':''}>
      <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></button>`;
    for (let i = 1; i <= total; i++)
      html += `<button class="page-btn ${i===page?'active':''}" onclick="changePage(${i})">${i}</button>`;
    html += `<button class="page-btn" onclick="changePage(${page+1})" ${page===total?'disabled':''}>
      <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>`;
    pg.innerHTML = html;
  }

  function changePage(p) {
    const total = Math.ceil(filtered.length / PER_PAGE);
    if (p < 1 || p > total) return;
    page = p; render();
  }

  /* ── Create Modal ── */
  function openCreateModal() {
    editId = null;
    document.getElementById('formModalTitle').textContent = 'Tambah Bahan';
    document.getElementById('formSubmitBtn').textContent  = 'Simpan';
    document.getElementById('inputNama').value   = '';
    document.getElementById('inputJumlah').value = '';
    document.getElementById('inputSatuan').value = '';
    openModal('formModal');
  }

  /* ── Edit Modal ── */
  function openEditModal(id) {
    const item = items.find(i => i.id === id);
    if (!item) return;
    editId = id;
    document.getElementById('formModalTitle').textContent = 'Edit Bahan';
    document.getElementById('formSubmitBtn').textContent  = 'Perbarui';
    document.getElementById('inputNama').value   = item.nama;
    document.getElementById('inputJumlah').value = Number(item.jumlah);
    document.getElementById('inputSatuan').value = item.satuan;
    openModal('formModal');
  }

  /* ── Submit Form ── */
  async function submitForm() {
    const nama   = document.getElementById('inputNama').value.trim().toUpperCase();
    const jumlah = parseInt(document.getElementById('inputJumlah').value);
    const satuan = document.getElementById('inputSatuan').value.trim();

    if (!nama)         { showToast('Masukkan nama bahan'); return; }
    if (isNaN(jumlah) || jumlah < 0) { showToast('Masukkan jumlah valid'); return; }
    if (!satuan)       { showToast('Masukkan satuan'); return; }

    const submitBtn = document.getElementById('formSubmitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Menyimpan...';

    try {
        const payload = { nama, jumlah, satuan };
        const url = editId ? `/owner/bahan/${editId}` : `/owner/bahan`;
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (data.success) {
            if (editId) {
                const idx = items.findIndex(i => i.id === editId);
                if (idx > -1) items[idx] = data.data;
            } else {
                items.push(data.data);
            }
            showToast(`${data.message}`);
            closeModal('formModal');
            filterData(); // re-render table
        } else {
            showToast('Gagal menyimpan data');
        }
    } catch (e) {
        showToast('Terjadi kesalahan server');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = editId ? 'Perbarui' : 'Simpan';
    }
  }

  /* ── Delete Modal ── */
  function openDeleteModal(id) {
    deleteId = id;
    const item = items.find(i => i.id === id);
    document.getElementById('deleteModalBody').textContent =
      `Yakin ingin menghapus "${item?.nama}"? Tindakan ini tidak dapat dibatalkan.`;
    openModal('deleteModal');
  }

  async function confirmDelete() {
    if (!deleteId) return;
    const item = items.find(i => i.id === deleteId);

    try {
        const res = await fetch(`/owner/bahan/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (data.success) {
            items = items.filter(i => i.id !== deleteId);
            closeModal('deleteModal');
            filterData();
            showToast(`${item?.nama} berhasil dihapus`);
            deleteId = null;
        } else {
            showToast('Gagal menghapus bahan');
        }
    } catch (e) {
        showToast('Terjadi kesalahan server');
    }
  }

  /* ── Modal helpers ── */
  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }

  document.querySelectorAll('.modal-overlay').forEach(el => {
    document.addEventListener('click', (e) => {
      const satuanWrapper = document.getElementById('satuanWrapper');
      if (satuanWrapper && !satuanWrapper.contains(e.target)) {
        document.getElementById('satuanDropdown').classList.remove('open');
        document.getElementById('satuanArrow').style.transform = 'translateY(-50%)';
      }
    });
  });

  /* ── Toast ── */
  let toastTimer;
  function showToast(msg) {
    clearTimeout(toastTimer);
    const el = document.getElementById('toast');
    el.textContent = msg;
    el.classList.add('show');
    toastTimer = setTimeout(() => el.classList.remove('show'), 2400);
  }

  const allSatuan = @json($satuans->values());

function buildSatuanDropdown(query) {
  const dropdown = document.getElementById('satuanDropdown');
  const current  = document.getElementById('inputSatuan').value.trim();
  const q        = query.toLowerCase();

  const matched = allSatuan.filter(s => s.toLowerCase().includes(q));
  const isNew   = current && !allSatuan.some(s => s.toLowerCase() === current.toLowerCase());

  let html = '';

  if (matched.length > 0) {
    html += matched.map(s => {
      const isActive = s.toLowerCase() === current.toLowerCase();
      return `<div class="satuan-dropdown-item ${isActive ? 'active' : ''}"
                   onclick="selectSatuan('${s.replace(/'/g,"\\'")}')">
        <span>${s}</span>
        ${isActive ? '' : ''}
      </div>`;
    }).join('');
  }

  if (isNew) {
    if (matched.length > 0) html += '<div class="satuan-divider"></div>';
    html += `<div class="satuan-dropdown-item"
                  onclick="selectSatuan('${current.replace(/'/g,"\\'")}')">
      <span>Tambah Satuan Baru "<strong>${current}</strong>"</span>
    </div>`;
  }

  dropdown.innerHTML = html;
}

function openSatuanDropdown() {
  buildSatuanDropdown(document.getElementById('inputSatuan').value);
  document.getElementById('satuanDropdown').classList.add('open');
  document.getElementById('satuanArrow').style.transform = 'translateY(-50%) rotate(180deg)';
}

function onSatuanInput() {
  buildSatuanDropdown(document.getElementById('inputSatuan').value);
  document.getElementById('satuanDropdown').classList.add('open');
}

function selectSatuan(value) {
  document.getElementById('inputSatuan').value = value;
  document.getElementById('satuanDropdown').classList.remove('open');
  document.getElementById('satuanArrow').style.transform = 'translateY(-50%)';
}

  /* ── Init ── */
  filtered = [...items];
  render();
</script>
</body>
</html>