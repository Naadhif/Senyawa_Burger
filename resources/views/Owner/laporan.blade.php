<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Laporan Keuangan – Owner</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --orange:      #e8500a;
      --orange-bg:   #ff6b2b;
      --green:       #4caf50;
      --blue:        #3b82f6;
      --purple:      #8b5cf6;
      --red:         #e85555;
      --red-dark:    #c83c3c;
      --surface:     #ffffff;
      --border:      #eeeeee;
      --text-dark:   #1a1008;
      --text-muted:  #888888;
      --radius:      16px;
      --pill:        100px;
      --cream:       #faefe2;
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
    .sidebar-id   { font-size: 13.5px; font-weight: 600; color: rgba(255,255,255,0.85); margin-top: 4px; margin-bottom: 28px; letter-spacing: 0.5px; }
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

    /* ══ MAIN ══ */
    .main { flex: 1; padding: 32px 36px 40px; overflow-y: auto; }

    .page-title {
      font-family: "Bebas Neue", cursive;
      font-size: 42px; font-weight: 400;
      color: var(--text-dark); letter-spacing: 2px; text-transform: uppercase;
      padding-bottom: 10px; border-bottom: 2px solid var(--orange);
      margin-bottom: 28px;
    }

    /* ══ SUMMARY CARDS ══ */
    .cards-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 16px;
      margin-bottom: 24px;
    }

    .summary-card {
      background: var(--surface);
      border: 2px solid var(--border);
      border-radius: var(--radius);
      padding: 20px 22px;
      display: flex; align-items: center; gap: 16px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.02);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-icon {
      width: 52px; height: 52px; border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .card-icon svg { width: 26px; height: 26px; fill: none; stroke-width: 2; stroke-linecap: round; }

    .card-icon.orange { background: rgba(232,80,10,0.12); }
    .card-icon.orange svg { stroke: var(--orange); }
    .card-icon.green  { background: rgba(76,175,80,0.12); }
    .card-icon.green  svg { stroke: var(--green); }
    .card-icon.blue   { background: rgba(59,130,246,0.12); }
    .card-icon.blue   svg { stroke: var(--blue); }
    .card-icon.purple { background: rgba(139,92,246,0.12); }
    .card-icon.purple svg { stroke: var(--purple); }

    .card-body { min-width: 0; }
    .card-label { font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.6px; }
    .card-value { font-family: "Bebas Neue", cursive; font-size: 1.65rem; letter-spacing: 1px; color: var(--text-dark); margin-top: 3px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .card-value.orange { color: var(--orange); }
    .card-value.green  { color: var(--green); }
    .card-value.blue   { color: var(--blue); }
    .card-value.purple { color: var(--purple); }

    /* ══ CONTENT GRID ══ */
    .content-grid {
      display: grid;
      grid-template-columns: 1fr 340px;
      gap: 20px;
      margin-bottom: 24px;
    }

    /* ══ TABLE CARD ══ */
.table-card {
  background: var(--surface);
  border: 2px solid var(--border);
  border-radius: var(--radius);
  overflow: hidden;
}

.table-card-header {
  padding: 15px 20px;
  border-bottom: 1.5px solid var(--border);
  display: flex; align-items: center; justify-content: space-between;
  background: var(--surface);
}

.table-card-title {
  font-size: 15px; font-weight: 800;
  color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.5px;
}

.table-count { font-size: 13px; color: var(--text-muted); font-weight: 500; }

.laporan-table { 
  width: 100%; 
  border-collapse: collapse; 
}

/* Bagian Head Tabel */
.laporan-table thead th {
  padding: 12px 16px;
  font-size: 11px; font-weight: 700;
  text-transform: uppercase; letter-spacing: 0.8px;
  color: var(--text-muted);
  border-bottom: 1.5px solid var(--border);
  text-align: center; /* SEMUA HEAD DIBUAT TENGAH */
  background: #FAFAF8;
}

.laporan-table tbody tr { transition: background 0.15s;  }
.laporan-table tbody tr:hover { background: #F5F2EE; }

.laporan-table tbody td {
  padding: 13px 16px;
  font-size: 13.5px; color: var(--text-dark);
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
  text-align: center;
}

.laporan-table tbody tr:last-child td { border-bottom: none; }

.badge-tipe {
  display: inline-block; padding: 3px 10px;
  border-radius: var(--pill); font-size: 11px; font-weight: 800;
  text-transform: uppercase; letter-spacing: 0.4px;
}

.badge-harian   { background: rgba(59,130,246,0.12); color: var(--blue); }
.badge-mingguan { background: rgba(139,92,246,0.12); color: var(--purple); }
.badge-bulanan  { background: rgba(232,80,10,0.12); color: var(--orange); }
.badge-tahunan  { background: rgba(76,175,80,0.12); color: var(--green); }

.td-pendapatan { font-weight: 700; color: var(--orange); }
.td-num        { font-weight: 600; color: var(--text-dark); }

.empty-state { text-align: center; padding: 48px 20px; color: var(--text-muted); }
.empty-icon  { font-size: 40px; margin-bottom: 10px; }
    /* Pagination */
    .pagination {
      display: flex; align-items: center; justify-content: flex-end;
      gap: 6px; padding: 14px 20px;
      border-top: 1px solid var(--border);
    }
    .page-btn {
      width: 32px; height: 32px;
      border: 1.5px solid var(--border); border-radius: 6px;
      background: #fff; font-family: "Nunito", sans-serif;
      font-size: 13px; font-weight: 600;
      color: var(--text-dark); cursor: pointer;
      display: flex; align-items: center; justify-content: center;
      transition: background 0.15s, border-color 0.15s;
    }
    .page-btn:hover  { border-color: var(--orange); color: var(--orange); }
    .page-btn.active { background: var(--orange); border-color: var(--orange); color: #fff; }
    .page-btn svg    { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2; fill: none; }

    /* ══ CHART CARD ══ */
    .chart-card {
      background: var(--surface);
      border: 2px solid var(--border);
      border-radius: var(--radius);
      padding: 20px;
      display: flex; flex-direction: column;
    }
    .chart-title {
      font-size: 15px; font-weight: 800;
      color: var(--text-dark); text-transform: uppercase; letter-spacing: 0.5px;
      margin-bottom: 4px;
    }
    .chart-subtitle { font-size: 12px; color: var(--text-muted); margin-bottom: 20px; font-weight: 600; }

    .chart-wrap { flex: 1; position: relative; min-height: 260px; }

    canvas#barChart { width: 100% !important; height: 100% !important; }

    .chart-legend {
      display: flex; gap: 16px; margin-top: 16px;
    }
    .legend-item {
      display: flex; align-items: center; gap: 6px;
      font-size: 12px; font-weight: 600; color: var(--text-muted);
    }
    .legend-dot {
      width: 10px; height: 10px; border-radius: 50%;
    }

    /* ══ FILTER BAR ══ */
    .filter-bar {
      background: var(--surface);
      border: 2px solid var(--border);
      border-radius: var(--radius);
      padding: 16px 20px;
      display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
      margin-bottom: 20px;
    }
    .filter-label { font-size: 13px; font-weight: 800; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; }

    .filter-select, .filter-date {
      border: 1.5px solid var(--border); border-radius: 10px;
      background: #fff; padding: 9px 13px;
      font-family: "Nunito", sans-serif; font-size: 13.5px;
      color: var(--text-dark); outline: none; cursor: pointer;
      transition: border-color 0.2s;
    }
    .filter-select:focus, .filter-date:focus { border-color: var(--orange); }

    .btn-filter {
      background: var(--orange); color: #fff; border: none;
      border-radius: 10px; padding: 9px 20px;
      font-family: "Nunito", sans-serif; font-size: 13.5px; font-weight: 700;
      cursor: pointer; transition: background 0.2s, transform 0.15s;
    }

    .btn-reset {
      background: #eee; color: var(--text-dark); border: none;
      border-radius: 10px; padding: 9px 16px;
      font-family: "Nunito", sans-serif; font-size: 13.5px; font-weight: 700;
      cursor: pointer; transition: background 0.2s;
      text-decoration: none; display: inline-flex; align-items: center;
    }
    .btn-reset:hover { background: #e0e0e0; }

    .btn-export {
      background: var(--green); color: #fff; border: none;
      border-radius: 10px; padding: 9px 20px;
      font-family: "Nunito", sans-serif; font-size: 13.5px; font-weight: 800;
      text-transform: uppercase; letter-spacing: 0.5px;
      cursor: pointer; transition: background 0.2s, transform 0.15s;
      box-shadow: 0 4px 12px rgba(76,175,80,0.3);
      display: flex; align-items: center; gap: 7px;
    }
    .btn-export:hover { background: var(--green); filter: brightness(1.1); transform: translateY(-1px); }
    .btn-export svg { width: 15px; height: 15px; stroke: #fff; stroke-width: 2.5; fill: none; }

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

    /* ══ NO DATA ══ */
    .no-data-chart {
      display: flex; flex-direction: column;
      align-items: center; justify-content: center;
      height: 100%; color: var(--text-muted);
      font-size: 13px; font-weight: 600; gap: 8px;
    }
    .no-data-chart svg { width: 40px; height: 40px; stroke: #ddd; stroke-width: 1.5; fill: none; }
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

  <a class="nav-item active" href="/owner/laporan">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    Laporan
  </a>
  <a class="nav-item" href="/owner/menu">
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
  <h1 class="page-title">Laporan Keuangan</h1>

  <!-- ── SUMMARY CARDS ── -->
  <div class="cards-grid">
    <!-- Pendapatan -->
    <div class="summary-card">
      <div class="card-icon orange">
        <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
      </div>
      <div class="card-body">
        <p class="card-label">Total Pendapatan</p>
        <p class="card-value orange" id="valPendapatan">
          Rp{{ number_format($summary['total_pendapatan'], 0, ',', '.') }}
        </p>
      </div>
    </div>
    <!-- Transaksi -->
    <div class="summary-card">
      <div class="card-icon green">
        <svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
      </div>
      <div class="card-body">
        <p class="card-label">Total Transaksi</p>
        <p class="card-value green" id="valTransaksi">{{ number_format($summary['total_transaksi'], 0, ',', '.') }}</p>
      </div>
    </div>
    <!-- Pesanan -->
    <div class="summary-card">
      <div class="card-icon blue">
        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
      </div>
      <div class="card-body">
        <p class="card-label">Jumlah Pesanan</p>
        <p class="card-value blue" id="valPesanan">{{ number_format($summary['jumlah_pesanan'], 0, ',', '.') }}</p>
      </div>
    </div>
    <!-- Item Terjual -->
    <div class="summary-card">
      <div class="card-icon purple">
        <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
      </div>
      <div class="card-body">
        <p class="card-label">Item Terjual</p>
        <p class="card-value purple" id="valTerjual">{{ number_format($summary['total_terjual'], 0, ',', '.') }}</p>
      </div>
    </div>
  </div>

  <!-- ── FILTER BAR ── -->
  <form method="GET" action="/owner/laporan" id="filterForm">
    <div class="filter-bar">
      <span class="filter-label">Filter:</span>

      <select class="filter-select" name="tipe_periode" onchange="this.form.submit()">
        <option value="semua"   {{ $tipe === 'semua'   ? 'selected' : '' }}>Semua Periode</option>
        <option value="harian"  {{ $tipe === 'harian'  ? 'selected' : '' }}>Harian</option>
        <option value="mingguan"{{ $tipe === 'mingguan'? 'selected' : '' }}>Mingguan</option>
        <option value="bulanan" {{ $tipe === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
        <option value="tahunan" {{ $tipe === 'tahunan' ? 'selected' : '' }}>Tahunan</option>
      </select>

      <input type="date" class="filter-date" name="dari"   value="{{ $dari }}"   placeholder="Dari tanggal" />
      <input type="date" class="filter-date" name="sampai" value="{{ $sampai }}" placeholder="Sampai tanggal" />

      <button type="submit" class="btn-filter">Terapkan</button>
      <a href="/owner/laporan" class="btn-reset">Reset</a>

      <button type="button" class="btn-export" onclick="exportCSV()" style="margin-left: auto;">
        <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
        Unduh CSV
      </button>

      <button type="button" class="btn-export" onclick="exportPDF()" style="background: var(--red); box-shadow: 0 4px 12px rgba(232, 85, 85, 0.3);">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Unduh PDF
      </button>
    </div>
  </form>

  <!-- ── CONTENT GRID ── -->
  <div class="content-grid">

    <!-- Tabel Laporan -->
    <div class="table-card">
      <div class="table-card-header">
        <span class="table-card-title">Riwayat Laporan</span>
        <span class="table-count" id="tableCount">{{ count($laporan) }} data</span>
      </div>

      <table class="laporan-table">
        <thead>
          <tr>
            <th>Periode</th>
            <th>Rentang Tanggal</th>
            <th>Pendapatan</th>
            <th>Transaksi</th>
            <th>Pesanan</th>
            <th>Item Terjual</th>
          </tr>
        </thead>
        <tbody id="laporanBody">
          @forelse($laporan as $row)
          <tr>
            <td>
              <span class="badge-tipe badge-{{ strtolower($row['tipe']) }}">{{ $row['tipe'] }}</span>
            </td>
            <td>
              <span style="font-weight:600;">{{ $row['dari'] }}</span>
              @if($row['dari'] !== $row['sampai'])
                <span style="color:var(--text-muted);"> — {{ $row['sampai'] }}</span>
              @endif
            </td>
            <td class="td-pendapatan">Rp{{ number_format($row['total_pendapatan'], 0, ',', '.') }}</td>
            <td class="td-num">{{ $row['total_transaksi'] }}</td>
            <td class="td-num">{{ $row['jumlah_pesanan'] }}</td>
            <td class="td-num">{{ $row['total_terjual'] }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6">
              <div class="empty-state">
                <div class="empty-icon">📊</div>
                <p>Belum ada data laporan untuk filter ini.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>

      <!-- Pagination (JS-driven) -->
      <div class="pagination" id="pagination"></div>
    </div>

    <!-- Chart Analitik -->
    <div class="chart-card">
      <p class="chart-title">Analitik Pendapatan</p>
      <p class="chart-subtitle">Tren pendapatan berdasarkan data tersedia</p>
      <div class="chart-wrap" id="chartWrap">
        @if(count($chartData) > 0)
          <canvas id="barChart"></canvas>
        @else
          <div class="no-data-chart">
            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            <span>Belum ada data untuk ditampilkan</span>
          </div>
        @endif
      </div>
      @if(count($chartData) > 0)
      <div class="chart-legend">
        <div class="legend-item">
          <div class="legend-dot" style="background:var(--orange);"></div>
          Pendapatan
        </div>
        <div class="legend-item">
          <div class="legend-dot" style="background:var(--blue);"></div>
          Pesanan
        </div>
      </div>
      @endif
    </div>
  </div>

</main>

<div class="toast" id="toast"></div>

<!-- Chart.js CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

<script>
/* ── Data dari PHP ── */
const allLaporan = @json($laporan);
const chartData  = @json($chartData);

/* ══════════════
   PAGINATION
══════════════ */
const PER_PAGE = 8;
let page = 1;

function renderPagination() {
  const total = Math.ceil(allLaporan.length / PER_PAGE);
  const pg = document.getElementById('pagination');
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
  const total = Math.ceil(allLaporan.length / PER_PAGE);
  if (p < 1 || p > total) return;
  page = p;
  renderTablePage();
  renderPagination();
}

function renderTablePage() {
  const tbody  = document.getElementById('laporanBody');
  const start  = (page - 1) * PER_PAGE;
  const slice  = allLaporan.slice(start, start + PER_PAGE);

  if (!slice.length) return; /* sudah ada forelse fallback dari Blade jika kosong */

  tbody.innerHTML = slice.map(row => {
    const badgeClass = 'badge-' + row.tipe.toLowerCase();
    const dateRange  = row.dari !== row.sampai
      ? `<span style="font-weight:600;">${row.dari}</span> <span style="color:var(--text-muted);"> — ${row.sampai}</span>`
      : `<span style="font-weight:600;">${row.dari}</span>`;
    return `
      <tr>
        <td><span class="badge-tipe ${badgeClass}">${row.tipe}</span></td>
        <td>${dateRange}</td>
        <td class="td-pendapatan">Rp${Number(row.total_pendapatan).toLocaleString('id-ID')}</td>
        <td class="td-num">${row.total_transaksi}</td>
        <td class="td-num">${row.jumlah_pesanan}</td>
        <td class="td-num">${row.total_terjual}</td>
      </tr>`;
  }).join('');
}

/* ══════════════
   BAR CHART
══════════════ */
if (chartData.length > 0) {
  const ctx = document.getElementById('barChart').getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: chartData.map(d => d.label),
      datasets: [
        {
          label: 'Pendapatan (Rp)',
          data: chartData.map(d => d.pendapatan),
          backgroundColor: 'rgba(232,80,10,0.75)',
          borderRadius: 6,
          borderSkipped: false,
          yAxisID: 'y',
        },
        {
          label: 'Pesanan',
          data: chartData.map(d => d.pesanan),
          backgroundColor: 'rgba(59,130,246,0.7)',
          borderRadius: 6,
          borderSkipped: false,
          yAxisID: 'y1',
          type: 'line',
          borderColor: 'rgba(59,130,246,0.9)',
          borderWidth: 2,
          pointBackgroundColor: '#3b82f6',
          pointRadius: 4,
          tension: 0.35,
          fill: false,
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#1a1008',
          titleColor: '#fff',
          bodyColor: 'rgba(255,255,255,0.75)',
          padding: 12,
          callbacks: {
            label: function(ctx) {
              if (ctx.datasetIndex === 0)
                return ' Rp' + Number(ctx.raw).toLocaleString('id-ID');
              return ' ' + ctx.raw + ' pesanan';
            }
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { font: { family: 'Nunito', size: 11, weight: '700' }, color: '#888' }
        },
        y: {
          position: 'left',
          grid: { color: '#f0ece8' },
          ticks: {
            font: { family: 'Nunito', size: 11 }, color: '#888',
            callback: v => 'Rp' + (v >= 1000000 ? (v/1000000).toFixed(1)+'jt' : v >= 1000 ? (v/1000).toFixed(0)+'rb' : v)
          }
        },
        y1: {
          position: 'right',
          grid: { display: false },
          ticks: { font: { family: 'Nunito', size: 11 }, color: '#3b82f6' }
        }
      }
    }
  });
}

/* ══════════════
   EXPORT CSV
══════════════ */
function exportCSV() {
  if (!allLaporan.length) { showToast('Tidak ada data untuk diekspor'); return; }

  const header = ['Periode','Dari','Sampai','Total Pendapatan','Total Transaksi','Jumlah Pesanan','Item Terjual','Generated At'];
  const rows = allLaporan.map(r => [
    r.tipe, r.dari, r.sampai,
    r.total_pendapatan, r.total_transaksi, r.jumlah_pesanan, r.total_terjual,
    r.generated_at
  ]);

  const csv = [header, ...rows].map(r => r.join(',')).join('\n');
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const url  = URL.createObjectURL(blob);
  const a    = document.createElement('a');
  a.href     = url;
  a.download = 'laporan-keuangan-' + new Date().toISOString().slice(0,10) + '.csv';
  a.click();
  URL.revokeObjectURL(url);
  showToast('File CSV berhasil diunduh!');
}

function exportPDF() {
  if (!allLaporan || !allLaporan.length) { 
      showToast('Tidak ada data untuk diekspor'); 
      return; 
  }

  // Inisialisasi jsPDF
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  // Menambahkan Judul ke PDF
  doc.setFontSize(16);
  doc.setTextColor(232, 80, 10); // Warna merah/oranye
  doc.text('Laporan Keuangan - Senyawa Burger', 14, 20);
  
  doc.setFontSize(10);
  doc.setTextColor(100, 100, 100);
  doc.text('Tanggal Unduh: ' + new Date().toISOString().slice(0,10), 14, 28);

  // Menyiapkan Header Tabel
  const head = [['Periode', 'Rentang', 'Total Pendapatan', 'Transaksi', 'Pesanan', 'Item Terjual']];

  // Menyiapkan Data Baris (Rows)
  const rows = allLaporan.map(r => {
      // Format rentang tanggal
      let rentang = r.dari && r.sampai ? `${r.dari} s/d ${r.sampai}` : '-';
      
      // Format mata uang Rupiah
      let pendapatan = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(r.total_pendapatan || 0);

      return [
          (r.tipe || '-').toUpperCase(),
          rentang,
          pendapatan,
          r.total_transaksi || '0',
          r.jumlah_pesanan || '0',
          r.total_terjual || '0'
      ];
  });

  // Membuat tabel di dalam PDF menggunakan AutoTable
  doc.autoTable({
      startY: 35,
      head: head,
      body: rows,
      theme: 'grid',
      headStyles: { fillColor: [232, 80, 10] }, // Warna header tabel
      styles: { fontSize: 9 },
      columnStyles: {
          2: { halign: 'right' }, // Rata kanan untuk kolom pendapatan
          3: { halign: 'center' },
          4: { halign: 'center' },
          5: { halign: 'center' }
      }
  });

  // Mengunduh File PDF
  const filename = 'laporan-keuangan-' + new Date().toISOString().slice(0,10) + '.pdf';
  doc.save(filename);
  
  showToast('File PDF berhasil diunduh!');
}

/* ══════════════
   TOAST
══════════════ */
let toastTimer;
function showToast(msg) {
  clearTimeout(toastTimer);
  const el = document.getElementById('toast');
  el.textContent = msg;
  el.classList.add('show');
  toastTimer = setTimeout(() => el.classList.remove('show'), 2400);
}

/* ── Init ── */
renderPagination();
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
</body>
</html>