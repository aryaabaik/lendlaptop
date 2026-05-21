@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')
@section('page_title', 'Laporan Peminjaman')
@section('breadcrumb')
  <span>Laporan</span>
@endsection

@section('content')
<style>
/* ── CSS VARIABLES (match global theme) ─────────────────────────── */
:root {
  --teal:      #0D9F7A;
  --teal-dk:   #0b8a6a;
  --teal-dim:  rgba(13,159,122,.10);
  --navy:      #0A1628;
  --red:       #EF4444;
  --amber:     #F59E0B;
  --blue:      #3B82F6;
  --text:      #1e293b;
  --muted:     #64748b;
  --border:    #e2e8f0;
  --bg:        #f8fafc;
}

/* ── LAYOUT ─────────────────────────────────────────────────────── */
.rpt-wrap { padding: 24px; }

/* ── PAGE HEADER ─────────────────────────────────────────────────── */
.rpt-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  margin-bottom: 24px;
}
.rpt-header h1 {
  font-size: 1.35rem;
  font-weight: 700;
  color: var(--text);
  letter-spacing: -.02em;
}
.rpt-header .sub {
  font-size: .8rem;
  color: var(--muted);
  margin-top: 2px;
}
.export-group {
  display: flex;
  gap: 8px;
}
.btn-exp {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 9px 18px;
  border-radius: 8px;
  font-size: .82rem;
  font-weight: 600;
  font-family: 'Inter', sans-serif;
  cursor: pointer;
  border: none;
  transition: all .2s ease;
  text-decoration: none;
}
.btn-exp-pdf {
  background: var(--navy);
  color: #fff;
}
.btn-exp-pdf:hover { background: #0f2040; transform: translateY(-1px); }
.btn-exp-xl {
  background: var(--teal);
  color: #fff;
  box-shadow: 0 4px 12px rgba(13,159,122,.22);
}
.btn-exp-xl:hover { background: var(--teal-dk); transform: translateY(-1px); }

/* ── FILTER CARD ─────────────────────────────────────────────────── */
.filter-card {
  background: #fff;
  border-radius: 16px;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 4px rgba(0,0,0,.04);
  padding: 20px 24px;
  margin-bottom: 24px;
}
.filter-grid {
  display: grid;
  grid-template-columns: 1fr 1fr auto;
  gap: 16px;
  align-items: flex-end;
}
@media (max-width: 680px) { .filter-grid { grid-template-columns: 1fr; } }

.f-label {
  display: block;
  font-size: .73rem;
  font-weight: 700;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: .05em;
  margin-bottom: 6px;
}
.f-wrap { position: relative; display: flex; align-items: center; }
.f-wrap i {
  position: absolute;
  left: 12px;
  color: #94a3b8;
  font-size: 1rem;
  pointer-events: none;
}
.f-input {
  width: 100%;
  background: #f8fafc;
  border: 1px solid var(--border);
  border-radius: 8px;
  padding: 9px 14px 9px 38px;
  font-family: 'Inter', sans-serif;
  font-size: .84rem;
  color: var(--text);
  outline: none;
  transition: all .2s;
}
.f-input:focus {
  border-color: var(--teal);
  box-shadow: 0 0 0 3px rgba(13,159,122,.12);
  background: #fff;
}
.btn-gen {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 22px;
  background: var(--teal);
  color: #fff;
  border: none;
  border-radius: 8px;
  font-size: .84rem;
  font-weight: 600;
  font-family: 'Inter', sans-serif;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(13,159,122,.22);
  transition: all .2s;
  white-space: nowrap;
}
.btn-gen:hover { background: var(--teal-dk); transform: translateY(-1px); }

/* ── STAT CARDS ──────────────────────────────────────────────────── */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 18px;
  margin-bottom: 24px;
}
@media (max-width: 1024px) { .stats-grid { grid-template-columns: 1fr 1fr; } }
@media (max-width: 560px)  { .stats-grid { grid-template-columns: 1fr; } }

.stat-card {
  background: #fff;
  border: 1px solid #f1f5f9;
  border-radius: 16px;
  box-shadow: 0 1px 4px rgba(0,0,0,.04);
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  transition: box-shadow .2s;
}
.stat-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.07); }
.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.35rem;
  flex-shrink: 0;
}
.stat-num {
  font-size: 1.55rem;
  font-weight: 800;
  color: var(--text);
  line-height: 1;
}
.stat-lbl {
  font-size: .73rem;
  font-weight: 600;
  color: var(--muted);
  margin-top: 4px;
  text-transform: uppercase;
  letter-spacing: .03em;
}

/* ── CHART CARD ──────────────────────────────────────────────────── */
.chart-card {
  background: #fff;
  border: 1px solid #f1f5f9;
  border-radius: 16px;
  box-shadow: 0 1px 4px rgba(0,0,0,.04);
  padding: 24px;
  margin-bottom: 24px;
}
.chart-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  padding-bottom: 14px;
  border-bottom: 1px solid #f1f5f9;
}
.chart-title {
  font-size: .92rem;
  font-weight: 700;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 8px;
}
.chart-title i { color: var(--teal); font-size: 1.1rem; }
.chart-period {
  font-size: .74rem;
  color: var(--muted);
  font-weight: 500;
  background: var(--bg);
  padding: 4px 10px;
  border-radius: 6px;
  border: 1px solid var(--border);
}

/* ── TABLE CARD ──────────────────────────────────────────────────── */
.tbl-card {
  background: #fff;
  border: 1px solid #f1f5f9;
  border-radius: 16px;
  box-shadow: 0 1px 4px rgba(0,0,0,.04);
  overflow: hidden;
  margin-bottom: 24px;
}
.tbl-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 18px 24px 16px;
  border-bottom: 1px solid #f1f5f9;
}
.tbl-head-title {
  font-size: .92rem;
  font-weight: 700;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 8px;
}
.tbl-head-title i { color: var(--teal); font-size: 1.1rem; }
.tbl-overflow { overflow-x: auto; }

.data-tbl {
  width: 100%;
  border-collapse: collapse;
  font-size: .82rem;
}
.data-tbl th {
  padding: 11px 16px;
  background: #f8fafc;
  color: var(--muted);
  font-size: .7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .05em;
  border-bottom: 1px solid var(--border);
  white-space: nowrap;
}
.data-tbl td {
  padding: 12px 16px;
  border-bottom: 1px solid #f8fafc;
  color: var(--text);
  vertical-align: middle;
}
.data-tbl tr:last-child td { border-bottom: none; }
.data-tbl tbody tr:hover { background: #fafcff; }

/* Rank badge */
.rank-badge {
  width: 28px;
  height: 28px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .75rem;
  font-weight: 800;
  margin: 0 auto;
}
.rank-1 { background: rgba(245,158,11,.15); color: #b45309; }
.rank-2 { background: rgba(148,163,184,.15); color: #475569; }
.rank-3 { background: rgba(205,127,50,.15);  color: #92400e; }
.rank-n { background: var(--teal-dim); color: var(--teal); }

/* Borrowings count bar */
.bar-wrap { display: flex; align-items: center; gap: 10px; }
.bar-track {
  flex: 1;
  height: 6px;
  background: #f1f5f9;
  border-radius: 4px;
  overflow: hidden;
}
.bar-fill {
  height: 100%;
  background: var(--teal);
  border-radius: 4px;
  transition: width .4s ease;
}
.bar-count {
  font-size: .8rem;
  font-weight: 700;
  color: var(--text);
  min-width: 32px;
  text-align: right;
}

/* Status Badge */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 10px;
  border-radius: 20px;
  font-size: .72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .03em;
  white-space: nowrap;
}
.badge-teal   { background: rgba(13,159,122,.12); color: var(--teal); }
.badge-blue   { background: rgba(59,130,246,.12);  color: var(--blue); }
.badge-amber  { background: rgba(245,158,11,.12);  color: #b45309; }
.badge-red    { background: rgba(239,68,68,.12);   color: var(--red); }
.badge-gray   { background: rgba(100,116,139,.1);  color: var(--muted); }

/* Empty state */
.empty-state {
  text-align: center;
  padding: 48px 20px;
  color: var(--muted);
}
.empty-state i {
  font-size: 2.5rem;
  display: block;
  margin-bottom: 12px;
  opacity: .3;
}
.empty-state p { font-size: .85rem; font-weight: 500; }

/* Pagination */
.pagi-wrap {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 12px;
  padding: 14px 24px;
  border-top: 1px solid #f1f5f9;
  font-size: .79rem;
  color: var(--muted);
}
.pagi-links {
  display: flex;
  align-items: center;
  gap: 4px;
}
.pagi-links a,
.pagi-links span {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 30px;
  height: 30px;
  padding: 0 8px;
  border-radius: 7px;
  font-size: .78rem;
  font-weight: 600;
  text-decoration: none;
  color: var(--muted);
  background: #f8fafc;
  border: 1px solid var(--border);
  transition: all .15s;
}
.pagi-links a:hover { background: var(--teal-dim); color: var(--teal); border-color: var(--teal); }
.pagi-links .active-pg { background: var(--teal); color: #fff; border-color: var(--teal); }
.pagi-links .disabled-pg { opacity: .4; pointer-events: none; }

@media print {
  .export-group, .filter-card, .pagi-wrap { display: none !important; }
}
</style>

<div class="rpt-wrap">

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  1. HEADER                                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="rpt-header">
  <div>
    <h1><i class="ti ti-chart-bar" style="color:var(--teal)"></i> Laporan Peminjaman</h1>
    <p class="sub">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d M Y') }}</p>
  </div>
  <div class="export-group">
    <button type="button" class="btn-exp btn-exp-pdf" onclick="window.print()">
      <i class="ti ti-file-type-pdf"></i> Export PDF
    </button>
    <button type="button" class="btn-exp btn-exp-xl" id="btn-export-excel">
      <i class="ti ti-file-spreadsheet"></i> Export Excel
    </button>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  2. FILTER PERIODE                                         --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="filter-card">
  <form method="GET" action="{{ route('admin.reports.index') }}">
    <div class="filter-grid">

      <div>
        <label class="f-label">Tanggal Mulai</label>
        <div class="f-wrap">
          <i class="ti ti-calendar"></i>
          <input type="date" name="start_date" class="f-input" value="{{ $startDate }}" required>
        </div>
      </div>

      <div>
        <label class="f-label">Tanggal Selesai</label>
        <div class="f-wrap">
          <i class="ti ti-calendar"></i>
          <input type="date" name="end_date" class="f-input" value="{{ $endDate }}" required>
        </div>
      </div>

      <div>
        <button type="submit" class="btn-gen">
          <i class="ti ti-refresh"></i> Generate
        </button>
      </div>

    </div>
  </form>
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  3. STAT SUMMARY (4 kolom)                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="stats-grid">

  {{-- Total Peminjaman --}}
  <div class="stat-card">
    <div class="stat-icon" style="background:var(--teal-dim); color:var(--teal)">
      <i class="ti ti-arrows-left-right"></i>
    </div>
    <div>
      <div class="stat-num">{{ $totalBorrowings }}</div>
      <div class="stat-lbl">Total Peminjaman</div>
    </div>
  </div>

  {{-- Dikembalikan --}}
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(59,130,246,.10); color:var(--blue)">
      <i class="ti ti-circle-check"></i>
    </div>
    <div>
      <div class="stat-num">{{ $totalReturns }}</div>
      <div class="stat-lbl">Dikembalikan</div>
    </div>
  </div>

  {{-- Masih Dipinjam --}}
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(245,158,11,.10); color:var(--amber)">
      <i class="ti ti-device-laptop"></i>
    </div>
    <div>
      <div class="stat-num">{{ $stillBorrowed }}</div>
      <div class="stat-lbl">Masih Dipinjam</div>
    </div>
  </div>

  {{-- Terlambat --}}
  <div class="stat-card">
    <div class="stat-icon" style="background:rgba(239,68,68,.10); color:var(--red)">
      <i class="ti ti-clock-x"></i>
    </div>
    <div>
      <div class="stat-num">{{ $lateBorrowings }}</div>
      <div class="stat-lbl">Terlambat</div>
    </div>
  </div>

</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  4. CHART: Peminjaman per Hari                             --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="chart-card">
  <div class="chart-head">
    <div class="chart-title">
      <i class="ti ti-chart-bar"></i>
      Peminjaman per Hari
    </div>
    <span class="chart-period">
      {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} — {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
    </span>
  </div>
  <div style="position:relative; height:280px;">
    <canvas id="dailyChart"></canvas>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  5. TABEL TOP: Laptop paling sering dipinjam               --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="tbl-card">
  <div class="tbl-head">
    <div class="tbl-head-title">
      <i class="ti ti-device-laptop"></i>
      Laptop Paling Sering Dipinjam
    </div>
    <span style="font-size:.74rem; color:var(--muted);">Periode yang dipilih</span>
  </div>
  <div class="tbl-overflow">
    <table class="data-tbl">
      <thead>
        <tr>
          <th style="text-align:center; width:56px">Rank</th>
          <th>Laptop</th>
          <th>Kode Unit</th>
          <th>Jumlah Dipinjam</th>
        </tr>
      </thead>
      <tbody>
        @php $maxCount = $topLaptops->max('borrowings_count') ?: 1; @endphp
        @forelse($topLaptops as $i => $lap)
          @php
            $rank = $i + 1;
            $rankClass = $rank === 1 ? 'rank-1' : ($rank === 2 ? 'rank-2' : ($rank === 3 ? 'rank-3' : 'rank-n'));
          @endphp
          <tr>
            <td>
              <div class="rank-badge {{ $rankClass }}">#{{ $rank }}</div>
            </td>
            <td>
              <div style="font-weight:600">{{ $lap->brand }} {{ $lap->model }}</div>
              <div style="font-size:.72rem; color:var(--muted)">{{ $lap->category->name ?? '—' }}</div>
            </td>
            <td>
              <code style="background:#f1f5f9; padding:2px 8px; border-radius:5px; font-size:.78rem; font-weight:700">{{ $lap->code }}</code>
            </td>
            <td>
              <div class="bar-wrap">
                <div class="bar-track">
                  <div class="bar-fill" style="width:{{ ($lap->borrowings_count / $maxCount) * 100 }}%"></div>
                </div>
                <span class="bar-count">{{ $lap->borrowings_count }}x</span>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4">
              <div class="empty-state">
                <i class="ti ti-device-laptop-off"></i>
                <p>Belum ada data peminjaman dalam periode ini.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  6. TABEL DETAIL: Semua peminjaman dalam periode           --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="tbl-card">
  <div class="tbl-head">
    <div class="tbl-head-title">
      <i class="ti ti-list-details"></i>
      Rincian Peminjaman
    </div>
    @if($detailBorrowings->total() > 0)
      <span style="font-size:.74rem; color:var(--muted)">
        {{ $detailBorrowings->total() }} transaksi ditemukan
      </span>
    @endif
  </div>

  <div class="tbl-overflow">
    <table class="data-tbl" id="tbl-rincian">
      <thead>
        <tr>
          <th style="text-align:center; width:48px">#</th>
          <th>Tanggal</th>
          <th>Hari</th>
          <th>Nama Peminjam</th>
          <th>Laptop</th>
          <th>Keperluan</th>
          <th style="text-align:center">Status</th>
        </tr>
      </thead>
      <tbody>
        @php
          $hariId = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
          $bulanId = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        @endphp
        @forelse($detailBorrowings as $i => $det)
          @php
            $dayNum  = (int)$det->borrow_date->format('w');
            $monNum  = (int)$det->borrow_date->format('n') - 1;
            $isLate  = $det->status === 'borrowed' && now()->gt($det->return_date);
          @endphp
          <tr>
            <td style="text-align:center; color:var(--muted); font-weight:600">
              {{ $detailBorrowings->firstItem() + $i }}
            </td>
            <td style="white-space:nowrap">
              {{ $det->borrow_date->format('d') }} {{ $bulanId[$monNum] }} {{ $det->borrow_date->format('Y') }}
            </td>
            <td>
              <span style="font-weight:600; color:var(--text)">{{ $hariId[$dayNum] }}</span>
            </td>
            <td>
              <div style="display:flex; align-items:center; gap:9px">
                <div style="width:30px; height:30px; border-radius:50%; background:var(--teal-dim); color:var(--teal); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:.68rem; flex-shrink:0">
                  {{ strtoupper(substr($det->user?->name ?? $det->borrower_name ?? 'U', 0, 2)) }}
                </div>
                <div>
                  <div style="font-weight:600">{{ $det->user?->name ?? $det->borrower_name ?? 'N/A' }}</div>
                  <div style="font-size:.7rem; color:var(--muted)">{{ $det->user?->kelas ?? 'Umum' }}</div>
                </div>
              </div>
            </td>
            <td>
              <div style="font-weight:600">{{ $det->laptop?->brand ?? '?' }} {{ $det->laptop?->model ?? '' }}</div>
              <div style="font-size:.7rem; color:var(--muted); font-family:monospace">{{ $det->laptop?->code ?? '—' }}</div>
            </td>
            <td style="max-width:180px">
              <span style="display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap" title="{{ $det->purpose }}">
                {{ $det->purpose ?? '—' }}
              </span>
            </td>
            <td style="text-align:center">
              @if($isLate)
                <span class="badge badge-red"><i class="ti ti-clock-x"></i> Terlambat</span>
              @elseif($det->status === 'returned')
                <span class="badge badge-teal"><i class="ti ti-circle-check"></i> Dikembalikan</span>
              @elseif($det->status === 'borrowed')
                <span class="badge badge-blue"><i class="ti ti-device-laptop"></i> Dipinjam</span>
              @elseif($det->status === 'approved')
                <span class="badge badge-teal">Disetujui</span>
              @elseif($det->status === 'pending')
                <span class="badge badge-amber"><i class="ti ti-clock"></i> Pending</span>
              @elseif($det->status === 'rejected')
                <span class="badge badge-red">Ditolak</span>
              @else
                <span class="badge badge-gray">{{ ucfirst($det->status) }}</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <i class="ti ti-clipboard-x"></i>
                <p>Tidak ada data peminjaman dalam periode yang dipilih.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($detailBorrowings->hasPages())
    <div class="pagi-wrap">
      <span>
        Menampilkan {{ $detailBorrowings->firstItem() }}–{{ $detailBorrowings->lastItem() }}
        dari {{ $detailBorrowings->total() }} peminjaman
      </span>
      <nav class="pagi-links">
        {{-- Prev --}}
        @if($detailBorrowings->onFirstPage())
          <span class="disabled-pg"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $detailBorrowings->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        {{-- Page numbers --}}
        @foreach($detailBorrowings->getUrlRange(1, $detailBorrowings->lastPage()) as $page => $url)
          @if($page == $detailBorrowings->currentPage())
            <span class="active-pg">{{ $page }}</span>
          @elseif(abs($page - $detailBorrowings->currentPage()) <= 2 || $page == 1 || $page == $detailBorrowings->lastPage())
            <a href="{{ $url }}">{{ $page }}</a>
          @elseif(abs($page - $detailBorrowings->currentPage()) == 3)
            <span style="color:var(--muted)">…</span>
          @endif
        @endforeach

        {{-- Next --}}
        @if($detailBorrowings->hasMorePages())
          <a href="{{ $detailBorrowings->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span class="disabled-pg"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif
</div>

</div>{{-- /rpt-wrap --}}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── DAILY BAR CHART ────────────────────────────────────────────────
(function () {
  var labels = {!! json_encode($dayLabels) !!};
  var values = {!! json_encode($dayValues) !!};

  var ctx = document.getElementById('dailyChart').getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Peminjaman',
        data: values,
        backgroundColor: 'rgba(13,159,122,0.82)',
        borderColor: '#0D9F7A',
        borderWidth: 1.5,
        borderRadius: 7,
        borderSkipped: false,
        barPercentage: 0.6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#0A1628',
          titleColor: '#e2e8f0',
          bodyColor: '#94a3b8',
          cornerRadius: 8,
          padding: 12,
          callbacks: {
            title: function(items) {
              return items[0].label;
            },
            label: function(item) {
              var n = item.parsed.y;
              return ' ' + n + (n === 1 ? ' peminjaman' : ' peminjaman');
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            color: '#94a3b8',
            font: { family: 'Inter', size: 11 }
          },
          grid: { color: '#f1f5f9' }
        },
        x: {
          grid: { display: false },
          ticks: {
            color: '#94a3b8',
            font: { family: 'Inter', size: 10 },
            maxRotation: 45,
            autoSkip: true,
            maxTicksLimit: 14
          }
        }
      }
    }
  });
})();

// ── EXPORT EXCEL ─────────────────────────────────────
document.getElementById('btn-export-excel').addEventListener('click', function() {
  const table = document.getElementById('tbl-rincian');
  if (!table) {
    alert('Tidak ada data untuk diexport.');
    return;
  }
  
  let csv = [];
  csv.push('sep=;');
  
  // Header row
  const headers = [];
  const headerCols = table.querySelectorAll('thead th');
  headerCols.forEach((col, idx) => {
    if (idx === 0) headers.push('No');
    else headers.push(col.innerText.trim());
  });
  csv.push(headers.join(';'));
  
  // Body rows
  const rows = table.querySelectorAll('tbody tr');
  rows.forEach((row) => {
    if (row.querySelector('.empty-state')) {
      return;
    }
    const cols = row.querySelectorAll('td');
    if (cols.length === 0) return;
    
    const rowData = [];
    cols.forEach((col, idx) => {
      let text = '';
      if (idx === 3) {
        // Nama Peminjam
        const divs = col.querySelectorAll('div');
        if (divs.length >= 3) {
          const nameText = divs[1].innerText.trim();
          const classText = divs[2].innerText.trim();
          text = classText ? `${nameText} (${classText})` : nameText;
        } else {
          text = col.innerText.trim();
        }
      } else if (idx === 4) {
        // Laptop
        const divs = col.querySelectorAll('div');
        if (divs.length >= 2) {
          const laptopText = divs[0].innerText.trim();
          const codeText = divs[1].innerText.trim();
          text = codeText && codeText !== '—' ? `${laptopText} [${codeText}]` : laptopText;
        } else {
          text = col.innerText.trim();
        }
      } else {
        text = col.innerText.trim().replace(/\r?\n|\r/g, " ");
      }
      
      text = text.replace(/"/g, '""');
      rowData.push(`"${text}"`);
    });
    csv.push(rowData.join(';'));
  });
  
  const csvContent = csv.join('\n');
  const blob = new Blob([new Uint8Array([0xEF, 0xBB, 0xBF]), csvContent], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.setAttribute('href', url);
  link.setAttribute('download', 'Laporan_Peminjaman_UNIBI.csv');
  link.style.visibility = 'hidden';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
});
</script>
@endpush
@endsection
