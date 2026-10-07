<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Menu – Admin</title>
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
    .main { flex: 1; padding: 32px 36px 40px; overflow-y: auto; }

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
      border: 1.5px solid var(--border);
      border-radius: var(--radius); overflow: hidden;
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

    .btn-create {
      background: var(--orange); color: #fff; border: none;
      border-radius: var(--pill); padding: 8px 20px;
      font-family: "Nunito", sans-serif;
      font-size: 13px; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.5px;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(232, 80, 10, 0.3);
      transition: background 0.2s, transform 0.15s, box-shadow 0.15s;
      margin-left: auto;
    }
    .btn-create:hover  { background: var(--orange-bg); box-shadow: 0 4px 12px rgba(232, 80, 10, 0.3); transform: translateY(-2px); }
    .btn-create:active { transform: scale(0.96); }

    .search-wrap {
      display: flex; align-items: center;
      border: 1.5px solid var(--border); border-radius: var(--radius);
      background: #fff; padding: 0 12px;
      flex: 1; max-width: 300px; transition: border-color 0.2s;
    }
    .search-wrap:focus-within { border-color: var(--orange); }
    .search-wrap svg { width: 16px; height: 16px; stroke: var(--text-muted); stroke-width: 2; fill: none; margin-right: 8px; flex-shrink: 0; }
    .search-wrap input {
      flex: 1; border: none; outline: none;
      font-family: "Nunito", sans-serif;
      font-size: 13.5px; color: var(--text-dark);
      padding: 9px 0; background: transparent;
    }
    .search-wrap input::placeholder { color: #C0BCB7; }

    /* Table */
    .menu-table { width: 100%; border-collapse: collapse; }

    .menu-table thead th {
      padding: 12px 20px;
      font-size: 11.5px; font-weight: 700;
      text-transform: uppercase; letter-spacing: 0.8px;
      color: var(--text-muted);
      border-bottom: 1.5px solid var(--border);
      text-align: center; background: #FAFAF8;
    }
    .menu-table thead th:nth-child(2) { text-align: left; }

    .menu-table tbody tr { transition: background 0.15s; }
    .menu-table tbody tr:hover { background: #F5F2EE; }

    .menu-table tbody td {
      padding: 18px 20px;
      font-size: 14px; color: var(--text-dark);
      border-bottom: 1px solid var(--border);
      vertical-align: middle; text-align: center;
    }
    .menu-table tbody tr:last-child td { border-bottom: none; }
    .menu-table tbody td:nth-child(2) { text-align: left; }

    /* Photo cell */
    .td-photo { width: 90px; }

    .menu-photo {
      width: 70px; height: 70px;
      border-radius: 10px;
      object-fit: cover;
      display: block; margin: 0 auto;
      box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    }

    .photo-placeholder {
      width: 70px; height: 70px;
      border-radius: 10px;
      background: var(--border);
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto;
    }
    .photo-placeholder svg { width: 28px; height: 28px; stroke: var(--text-muted); stroke-width: 1.5; fill: none; }

    /* Name cell */
    .td-name { font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; }

    /* Ingredients */
    .bahan-list {
      display: flex; flex-direction: column; gap: 3px;
      align-items: center;
    }
    .bahan-tag {
      font-size: 12.5px; color: var(--text-muted);
      font-weight: 500; text-transform: uppercase;
      letter-spacing: 0.3px; line-height: 1.5;
    }

    /* Price */
    .td-price { font-weight: 700; color: var(--orange); }

    /* Action buttons */
    .action-btns { display: flex; flex-direction: column; align-items: center; gap: 7px; }

    .btn-action {
      display: inline-block;
      padding: 6px 18px; border-radius: var(--pill); border: none;
      font-family: "Nunito", sans-serif;
      font-size: 12px; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.5px;
      cursor: pointer; min-width: 80px;
      transition: filter 0.15s, transform 0.15s;
    }
    .btn-action:hover  { filter: brightness(1.1); }
    .btn-action:active { transform: scale(0.95); }
    .btn-update { background: var(--green); color: #fff; }
    .btn-delete { background: var(--red);   color: #fff; }

    /* Empty */
    .empty-state { text-align: center; padding: 60px 20px; color: var(--text-muted); }
    .empty-icon  { font-size: 44px; margin-bottom: 12px; }

    /* Pagination */
    .pagination {
      display: flex; align-items: center; justify-content: flex-end;
      gap: 6px; padding: 14px 20px; border-top: 1px solid var(--border);
    }
    .page-btn {
      width: 32px; height: 32px;
      border: 1.5px solid var(--border); border-radius: 6px;
      background: #fff;
      font-family: "Nunito", sans-serif; font-size: 13px; font-weight: 600;
      color: var(--text-dark); cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.15s, border-color 0.15s;
    }
    .page-btn:hover  { border-color: var(--orange); color: var(--orange); }
    .page-btn.active { background: var(--orange); border-color: var(--orange); color: #fff; }
    .page-btn svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2; fill: none; }

    .badge-status {
  display: inline-block; padding: 5px 14px;
  border-radius: var(--pill); font-size: 12px; font-weight: 800;
  text-transform: uppercase; letter-spacing: 0.4px;
}
.badge-tersedia { background: var(--green); color: #ffffffff; }
.badge-tidak    { background: var(--red) ; color: #fff; }

    /* ══ MODAL ══ */
    .modal-overlay {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.45); z-index: 200;
      align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; animation: mfade 0.2s ease; }
    @keyframes mfade { from{opacity:0;} to{opacity:1;} }

    .modal {
      background: #fff; border-radius: 14px;
      padding: 28px; max-width: 500px; width: 92%;
      max-height: 90vh; overflow-y: auto;
      animation: mslide 0.25s cubic-bezier(0.22,1,0.36,1);
    }
    @keyframes mslide { from{transform:scale(0.92);opacity:0;} to{transform:scale(1);opacity:1;} }

    .modal-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 22px;
    }
    .modal-title { font-size: 18px; font-weight: 800; color: var(--text-dark); }
    .btn-close {
      background: none; border: none; cursor: pointer;
      font-size: 22px; color: var(--text-muted); line-height: 1;
      transition: color 0.2s;
    }
    .btn-close:hover { color: var(--text-dark); }

    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 13.5px; font-weight: 600; color: var(--text-dark); margin-bottom: 7px; }

    .form-input, .form-textarea {
      width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius);
      padding: 10px 13px;
      font-family: "Nunito", sans-serif; font-size: 14px; color: var(--text-dark);
      outline: none; background: #fff;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus, .form-textarea:focus {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(224,138,30,0.2);
    }
    .form-textarea { resize: vertical; min-height: 80px; }

    /* Photo upload area */
    .photo-upload {
      border: 2px dashed var(--border); border-radius: var(--radius);
      padding: 20px; text-align: center; cursor: pointer;
      transition: border-color 0.2s, background 0.2s;
      position: relative;
    }
    .photo-upload:hover { border-color: var(--orange); background: #FFF8EE; }
    .photo-upload input { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
    .photo-upload-icon { font-size: 32px; margin-bottom: 8px; }
    .photo-upload-text { font-size: 13px; color: var(--text-muted); }
    .photo-upload-preview {
      width: 80px; height: 80px; border-radius: 10px;
      object-fit: cover; margin: 0 auto 8px;
      display: block;
    }

    /* Tags input for bahan */
    .tags-container {
      border: 1.5px solid var(--border); border-radius: var(--radius);
      padding: 8px 10px; background: #fff; min-height: 50px;
      display: flex; flex-wrap: wrap; gap: 6px; cursor: text;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .tags-container:focus-within {
      border-color: var(--orange);
      box-shadow: 0 0 0 3px rgba(224,138,30,0.2);
    }
    .tag-item {
      background: #EEE; border-radius: 20px;
      padding: 4px 10px; font-size: 12.5px; font-weight: 600;
      color: var(--text-dark); display: flex; align-items: center; gap: 5px;
    }
    .tag-remove {
      cursor: pointer; color: var(--text-muted); font-size: 14px; line-height: 1;
      transition: color 0.15s;
    }
    .tag-remove:hover { color: var(--red); }
    .tag-input {
      border: none; outline: none; flex: 1; min-width: 100px;
      font-family: "Nunito", sans-serif; font-size: 13.5px; color: var(--text-dark);
      background: transparent; padding: 4px 2px;
    }

    .modal-actions { display: flex; gap: 10px; margin-top: 24px; }
    .modal-btn {
      flex: 1; padding: 11px; border: none; border-radius: 8px;
      font-family: "Nunito", sans-serif; font-size: 14px; font-weight: 700;
      cursor: pointer; transition: background 0.2s;
    }
    .modal-btn.cancel { background: #EEE; color: var(--text-dark); }
    .modal-btn.cancel:hover { background: #DDD; }
    .modal-btn.submit { background: var(--purple); color: #fff; }
    .modal-btn.submit:hover { background: var(--purple-dark); }
    .modal-btn.danger { background: var(--red); color: #fff; }
    .modal-btn.danger:hover { background: var(--red-dark); }

    /* ══ TOAST ══ */
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
  <a class="nav-item" href="/owner/bahan" onclick="showToast('Mengelola Stok')">
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
  <h1 class="page-title">Daftar Menu</h1>

  <!-- Toolbar -->
  <div class="toolbar">
    <div class="search-wrap">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="searchInput" placeholder="Cari nama menu…" oninput="filterData()" />
    </div>
    <button class="btn-create" onclick="window.location.href='/owner/menu/create'">CREATE MENU</button>
  </div>

  <div class="table-card">
    <div class="table-card-header">
      <span class="table-card-title">Daftar Menu</span>
    </div>

    <table class="menu-table">
      <thead>
        <tr>
          <th>Foto</th>
          <th>Nama Menu</th>
          <th>Kategori</th>
          <th>Bahan yang Diperlukan</th>
          <th>Harga</th>
          <th>Ketersediaan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody id="menuBody"></tbody>
    </table>

    <div class="pagination" id="pagination"></div>
  </div>
</main>

<!-- ═══ FORM MODAL ═══ -->
<div class="modal-overlay" id="formModal">
  <div class="modal">
    <div class="modal-header">
      <p class="modal-title" id="formModalTitle">Tambah Menu</p>
      <button class="btn-close" onclick="closeModal('formModal')">✕</button>
    </div>

    <!-- Photo Upload -->
    <div class="form-group">
      <label class="form-label">Foto Menu</label>
      <div class="photo-upload" id="photoUploadArea">
        <input type="file" accept="image/*" id="photoInput" onchange="handlePhoto(event)" />
        <img id="photoPreview" class="photo-upload-preview" style="display:none;" />
        <div id="photoPlaceholder">
          <div class="photo-upload-icon">📷</div>
          <div class="photo-upload-text">Klik untuk upload foto</div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Nama Menu</label>
      <input class="form-input" id="inputNama" type="text" placeholder="cth. Cheese Burger, Beef Burger…" />
    </div>

    <div class="form-group">
      <label class="form-label">Harga (Rp)</label>
      <input class="form-input" id="inputHarga" type="number" min="0" step="500" placeholder="cth. 24500" />
    </div>

    <div class="form-group">
      <label class="form-label">Bahan yang Diperlukan <span style="color:var(--text-muted);font-weight:400;">(ketik lalu Enter)</span></label>
      <div class="tags-container" id="tagsContainer" onclick="document.getElementById('tagInput').focus()">
        <input class="tag-input" id="tagInput" placeholder="Tambah bahan…" onkeydown="handleTagInput(event)" />
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Deskripsi <span style="color:var(--text-muted);font-weight:400;">(opsional)</span></label>
      <textarea class="form-textarea" id="inputDesc" placeholder="Deskripsi singkat menu…"></textarea>
    </div>

    <div class="modal-actions">
      <button class="modal-btn cancel" onclick="closeModal('formModal')">Batal</button>
      <button class="modal-btn submit" id="formSubmitBtn" onclick="submitForm()">Simpan</button>
    </div>
  </div>
</div>

<!-- ═══ DELETE MODAL ═══ -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal" style="max-width:360px; text-align:center;">
    <div style="font-size:44px;margin-bottom:12px;">🗑️</div>
    <p class="modal-title" style="margin-bottom:8px;">Hapus Menu?</p>
    <p style="font-size:14px;color:var(--text-muted);margin-bottom:22px;" id="deleteModalBody">Tindakan ini tidak dapat dibatalkan.</p>
    <div class="modal-actions">
      <button class="modal-btn cancel" onclick="closeModal('deleteModal')">Batal</button>
      <button class="modal-btn danger" onclick="confirmDelete()">Ya, Hapus</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
  /* ── Data ── */
  let menus = @json($menus);

  let filtered = [...menus];
  let editId   = null;
  let deleteId = null;
  let tags     = [];
  let photoDataUrl = null;

  const PER_PAGE = 8;
  let page = 1;

  /* ── Format ── */
  function fmt(n) { return 'Rp' + n.toLocaleString('id-ID'); }

  /* ── Render ── */
  function render() {
    const tbody = document.getElementById('menuBody');
    tbody.innerHTML = '';
    const start = (page - 1) * PER_PAGE;
    const slice = filtered.slice(start, start + PER_PAGE);

    if (!slice.length) {
      tbody.innerHTML = `<tr><td colspan="7">
        <div class="empty-state"><div class="empty-icon">🍔</div><p>Tidak ada menu ditemukan</p></div>
      </td></tr>`;
    } else {
      slice.forEach(item => {
        const tr = document.createElement('tr');
        const bahanHtml = item.bahan.map(b => `<span class="bahan-tag">${b}</span>`).join('');
        const fotoHtml  = item.foto
          ? `<img class="menu-photo" src="${item.foto}" alt="${item.nama}" onerror="this.style.display='none'">`
          : `<div class="photo-placeholder"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>`;

        tr.innerHTML = `
          <td class="td-photo">${fotoHtml}</td>
          <td class="td-name">${item.nama}</td>
          <td><span style="background:var(--cream); color:var(--orange-bg); padding:4px 8px; border-radius:6px; font-size:12px; font-weight:700; text-transform:uppercase;">${item.kategori || '-'}</span></td>
          <td><div class="bahan-list">${bahanHtml}</div></td>
          <td class="td-price">${fmt(item.harga)}</td>
          <td>
            <span class="badge-status ${item.status ? 'badge-tersedia' : 'badge-tidak'}">
              ${item.status ? 'Tersedia' : 'Tidak Tersedia'}
            </span>
          </td>
          <td>
            <div class="action-btns">
              <button class="btn-action btn-update" onclick="window.location.href='/owner/menu/${item.id}/edit'">UPDATE</button>
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
    filtered = menus.filter(m => m.nama.toLowerCase().includes(q));
    page = 1; render();
  }

  /* ── Pagination ── */
  function renderPagination() {
    const total = Math.ceil(filtered.length / PER_PAGE);
    const pg    = document.getElementById('pagination');
    if (total <= 1) { pg.innerHTML = ''; return; }
    let html = `<button class="page-btn" onclick="changePage(${page-1})" ${page===1?'disabled':''}><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></button>`;
    for (let i = 1; i <= total; i++)
      html += `<button class="page-btn ${i===page?'active':''}" onclick="changePage(${i})">${i}</button>`;
    html += `<button class="page-btn" onclick="changePage(${page+1})" ${page===total?'disabled':''}><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></button>`;
    pg.innerHTML = html;
  }

  function changePage(p) {
    const total = Math.ceil(filtered.length / PER_PAGE);
    if (p < 1 || p > total) return;
    page = p; render();
  }

  /* ── Tags ── */
  function renderTags() {
    const container = document.getElementById('tagsContainer');
    const input     = document.getElementById('tagInput');
    container.innerHTML = '';
    tags.forEach((tag, i) => {
      const span = document.createElement('span');
      span.className = 'tag-item';
      span.innerHTML = `${tag} <span class="tag-remove" onclick="removeTag(${i})">×</span>`;
      container.appendChild(span);
    });
    container.appendChild(input);
    input.focus();
  }

  function removeTag(i) {
    tags.splice(i, 1); renderTags();
  }

  function handleTagInput(e) {
    if (e.key === 'Enter' || e.key === ',') {
      e.preventDefault();
      const val = e.target.value.trim().toUpperCase();
      if (val && !tags.includes(val)) { tags.push(val); renderTags(); }
      e.target.value = '';
    } else if (e.key === 'Backspace' && !e.target.value && tags.length) {
      tags.pop(); renderTags();
    }
  }

  /* ── Photo ── */
  function handlePhoto(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
      photoDataUrl = ev.target.result;
      document.getElementById('photoPreview').src = photoDataUrl;
      document.getElementById('photoPreview').style.display = 'block';
      document.getElementById('photoPlaceholder').style.display = 'none';
    };
    reader.readAsDataURL(file);
  }

  function resetPhotoUpload(url = null) {
    photoDataUrl = url;
    const preview = document.getElementById('photoPreview');
    const placeholder = document.getElementById('photoPlaceholder');
    document.getElementById('photoInput').value = '';
    if (url) {
      preview.src = url;
      preview.style.display = 'block';
      placeholder.style.display = 'none';
    } else {
      preview.style.display = 'none';
      placeholder.style.display = 'block';
    }
  }

  /* ── CREATE Modal ── */
  function openCreateModal() {
    editId = null;
    document.getElementById('formModalTitle').textContent = 'Tambah Menu';
    document.getElementById('formSubmitBtn').textContent  = 'Simpan';
    document.getElementById('inputNama').value  = '';
    document.getElementById('inputHarga').value = '';
    document.getElementById('inputDesc').value  = '';
    tags = [];
    renderTags();
    resetPhotoUpload();
    openModal('formModal');
  }

  /* ── EDIT Modal ── */
  function openEditModal(id) {
    const item = menus.find(m => m.id === id);
    if (!item) return;
    editId = id;
    document.getElementById('formModalTitle').textContent = 'Edit Menu';
    document.getElementById('formSubmitBtn').textContent  = 'Perbarui';
    document.getElementById('inputNama').value  = item.nama;
    document.getElementById('inputHarga').value = item.harga;
    document.getElementById('inputDesc').value  = item.desc || '';
    tags = [...item.bahan];
    renderTags();
    resetPhotoUpload(item.foto);
    openModal('formModal');
  }

  /* ── Submit ── */
  function submitForm() {
    const nama  = document.getElementById('inputNama').value.trim().toUpperCase();
    const harga = parseInt(document.getElementById('inputHarga').value);
    const desc  = document.getElementById('inputDesc').value.trim();
    const tagVal = document.getElementById('tagInput').value.trim().toUpperCase();
    if (tagVal) { tags.push(tagVal); document.getElementById('tagInput').value = ''; }

    if (!nama)            { showToast('⚠️ Masukkan nama menu'); return; }
    if (isNaN(harga) || harga < 0) { showToast('⚠️ Masukkan harga valid'); return; }

    const foto = photoDataUrl || (editId ? menus.find(m => m.id === editId)?.foto : null);

    if (editId) {
      const item = menus.find(m => m.id === editId);
      Object.assign(item, { nama, harga, bahan: [...tags], desc, foto });
      showToast(`✏️ ${nama} berhasil diperbarui`);
    } else {
      menus.push({ id: counter++, nama, harga, bahan: [...tags], desc, foto });
      showToast(`✅ ${nama} berhasil ditambahkan`);
    }

    closeModal('formModal');
    filterData();
  }

  /* ── DELETE ── */
  function openDeleteModal(id) {
    deleteId = id;
    const item = menus.find(m => m.id === id);
    document.getElementById('deleteModalBody').textContent =
      `Yakin ingin menghapus menu "${item?.nama}"? Tindakan ini tidak dapat dibatalkan.`;
    openModal('deleteModal');
  }

  async function confirmDelete() {
    if (!deleteId) return;
    const item = menus.find(i => i.id === deleteId);

    try {
        const res = await fetch(`/owner/menu/${deleteId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await res.json();

        if (data.success) {
            menus = menus.filter(m => m.id !== deleteId);
            closeModal('deleteModal');
            filterData();
            showToast(`${item?.nama} berhasil dihapus`);
            deleteId = null;
        } else {
            showToast('Gagal menghapus menu');
        }
    } catch (e) {
        showToast('Terjadi kesalahan server');
    }
  }

  /* ── Modal helpers ── */
  function openModal(id)  { document.getElementById(id).classList.add('open'); }
  function closeModal(id) { document.getElementById(id).classList.remove('open'); }

  document.querySelectorAll('.modal-overlay').forEach(el => {
    el.addEventListener('click', e => { if (e.target === el) el.classList.remove('open'); });
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

  /* ── Init ── */
  filtered = [...menus];
  render();
</script>
</body>
</html>