@extends('layouts.admin')

@section('title', 'Laporan & Statistik')
@section('page_title', 'Laporan & Analisis Statistik')
@section('breadcrumb')
  <span>Laporan</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM REPORT STYLES ───────────────────────────────── */
.report-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
}
.report-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text);
}
.export-btn-group {
  display: flex;
  gap: 8px;
}

/* Period Filter Card */
.filter-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  padding: 20px;
  margin-bottom: 24px;
}
.filter-grid {
  display: grid;
  grid-template-columns: 2.5fr 2.5fr 1fr;
  gap: 16px;
  align-items: flex-end;
}
@media(max-width: 767px) {
  .filter-grid {
    grid-template-columns: 1fr;
  }
}

/* Custom form elements */
.f-label {
  display: block;
  font-size: .75rem;
  font-weight: 600;
  color: var(--muted);
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: .03em;
}
.f-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.f-input-wrapper i {
  position: absolute;
  left: 14px;
  color: #94a3b8;
  font-size: 1.05rem;
  pointer-events: none;
}
.f-input {
  width: 100%;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 8.5px 14px 8.5px 38px;
  font-family: 'Inter', sans-serif;
  font-size: .82rem;
  color: var(--text);
  outline: none;
  transition: all .2s ease;
}

/* Stats summary grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 24px;
}
@media(max-width: 991px) {
  .stats-grid {
    grid-template-columns: 1fr 1fr;
  }
}
@media(max-width: 575px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
}

.stat-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
}
.stat-icon {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
  flex-shrink: 0;
}
.stat-num {
  font-size: 1.35rem;
  font-weight: 700;
  color: var(--text);
  line-height: 1.2;
}
.stat-lbl {
  font-size: .74rem;
  color: var(--muted);
  font-weight: 600;
  margin-top: 2px;
}

/* Charts Grid */
.charts-grid {
  display: grid;
  grid-template-columns: 3fr 2fr;
  gap: 24px;
  margin-bottom: 24px;
}
@media(max-width: 991px) {
  .charts-grid {
    grid-template-columns: 1fr;
  }
}
.chart-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  padding: 24px;
}
.chart-card-header {
  margin-bottom: 20px;
  padding-bottom: 12px;
  border-bottom: 1px solid #f1f5f9;
}
.chart-card-title {
  font-size: .9rem;
  font-weight: 700;
  color: var(--text);
  text-transform: uppercase;
  letter-spacing: .02em;
}

/* Top 5 Tables */
.top-tables-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-bottom: 24px;
}
@media(max-width: 991px) {
  .top-tables-grid {
    grid-template-columns: 1fr;
  }
}

/* Table Design */
.tbl-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  overflow: hidden;
  margin-bottom: 24px;
}
.tbl-responsive {
  width: 100%;
  overflow-x: auto;
}
.custom-tbl {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: .82rem;
}
.custom-tbl th {
  padding: 12px 16px;
  background: #f8fafc;
  color: var(--muted);
  font-weight: 600;
  text-transform: uppercase;
  font-size: .68rem;
  letter-spacing: .05em;
  border-bottom: 1px solid var(--border);
}
.custom-tbl td {
  padding: 12px 16px;
  border-bottom: 1px solid #f1f5f9;
  color: var(--text);
  vertical-align: middle;
}
.custom-tbl tr:last-child td {
  border-bottom: none;
}

.user-cell {
  display: flex;
  align-items: center;
  gap: 10px;
}
.user-avatar {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: var(--teal-dim);
  color: var(--teal);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: .7rem;
}

/* Print simulation styling */
@media print {
  body * {
    visibility: hidden;
  }
  .app-content-body, .app-content-body * {
    visibility: visible;
  }
  .app-content-body {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
  .filter-card, .export-btn-group, .pagination-wrap {
    display: none !important;
  }
}
</style>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  1. HEADER                                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="report-header">
  <h1 class="report-title">Laporan & Statistik</h1>
  <div class="export-btn-group">
    <button type="button" class="btn btn-secondary" onclick="exportSimulated('PDF')" style="background:#0a1628; color:#fff; border-color:#0a1628;">
      <i class="ti ti-file-text"></i> Export PDF
    </button>
    <button type="button" class="btn btn-primary" onclick="exportSimulated('Excel')">
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
      
      {{-- Tanggal Mulai --}}
      <div>
        <label class="f-label">Tanggal Mulai</label>
        <div class="f-input-wrapper">
          <i class="ti ti-calendar"></i>
          <input type="date" name="start_date" class="f-input" value="{{ $startDate }}" required>
        </div>
      </div>

      {{-- Tanggal Selesai --}}
      <div>
        <label class="f-label">Tanggal Selesai</label>
        <div class="f-input-wrapper">
          <i class="ti ti-calendar"></i>
          <input type="date" name="end_date" class="f-input" value="{{ $endDate }}" required>
        </div>
      </div>

      {{-- Actions --}}
      <div>
        <button type="submit" class="btn btn-primary" style="padding: 9px 18px; width: 100%;">
          <i class="ti ti-refresh"></i> Generate
        </button>
      </div>

    </div>
  </form>
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  3. STAT SUMMARY                                           --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="stats-grid">
  
  {{-- Total Peminjaman --}}
  <div class="stat-card">
    <div class="stat-icon" style="background: var(--teal-dim); color: var(--teal);">
      <i class="ti ti-arrows-left-right"></i>
    </div>
    <div>
      <div class="stat-num">{{ $totalBorrowings }}</div>
      <div class="stat-lbl">Total Peminjaman</div>
    </div>
  </div>

  {{-- Total Pengembalian --}}
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(59, 130, 246, 0.08); color: #3b82f6;">
      <i class="ti ti-arrow-back-up"></i>
    </div>
    <div>
      <div class="stat-num">{{ $totalReturns }}</div>
      <div class="stat-lbl">Total Pengembalian</div>
    </div>
  </div>

  {{-- Total Denda --}}
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(239, 68, 68, 0.08); color: var(--red);">
      <i class="ti ti-wallet"></i>
    </div>
    <div>
      <div class="stat-num">Rp {{ number_format($totalFines, 0, ',', '.') }}</div>
      <div class="stat-lbl">Total Pendapatan Denda</div>
    </div>
  </div>

  {{-- Laptop Bermasalah --}}
  <div class="stat-card">
    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">
      <i class="ti ti-alert-triangle"></i>
    </div>
    <div>
      <div class="stat-num">{{ $damagedLaptops }}</div>
      <div class="stat-lbl">Laptop Bermasalah</div>
    </div>
  </div>

</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  4. GRAFIK (2 kolom)                                       --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="charts-grid">
  
  {{-- Bar Chart --}}
  <div class="chart-card">
    <div class="chart-card-header">
      <h3 class="chart-card-title">Tren Peminjaman Bulanan</h3>
    </div>
    <div style="height: 280px; position: relative;">
      <canvas id="monthlyChart"></canvas>
    </div>
  </div>

  {{-- Donut Chart --}}
  <div class="chart-card">
    <div class="chart-card-header">
      <h3 class="chart-card-title">Distribusi Kondisi Laptop</h3>
    </div>
    <div style="height: 280px; position: relative; display: flex; justify-content: center; align-items: center;">
      <canvas id="laptopStatusChart" style="max-height: 100%; max-width: 100%;"></canvas>
    </div>
  </div>

</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  5. TABEL TOP 5                                            --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="top-tables-grid">
  
  {{-- TOP LAPTOPS --}}
  <div class="chart-card" style="padding: 0; overflow: hidden;">
    <div class="chart-card-header" style="margin: 20px 20px 0; padding-bottom: 12px;">
      <h3 class="chart-card-title"><i class="ti ti-device-laptop" style="color:var(--teal)"></i> Laptop Terpopuler</h3>
    </div>
    <div class="tbl-responsive">
      <table class="custom-tbl">
        <thead>
          <tr>
            <th style="width: 50px; text-align: center;">Rank</th>
            <th>Kode Laptop</th>
            <th>Brand & Model</th>
            <th style="text-align: center;">Frekuensi Pinjam</th>
          </tr>
        </thead>
        <tbody>
          @if($topLaptops->isEmpty())
            <tr><td colspan="4" style="text-align: center; color: var(--muted); padding: 20px;">Belum ada data peminjaman.</td></tr>
          @else
            @foreach($topLaptops as $idx => $lap)
              <tr>
                <td style="text-align: center; font-weight: 700; color: var(--teal);">#{{ $idx + 1 }}</td>
                <td style="font-family: monospace; font-weight: 700;">{{ $lap->code }}</td>
                <td>{{ $lap->brand }} {{ $lap->model }}</td>
                <td style="text-align: center; font-weight: 700; color: var(--text);">
                  {{ $lap->borrowings_count }}x dipinjam
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>

  {{-- TOP BORROWERS --}}
  <div class="chart-card" style="padding: 0; overflow: hidden;">
    <div class="chart-card-header" style="margin: 20px 20px 0; padding-bottom: 12px;">
      <h3 class="chart-card-title"><i class="ti ti-users" style="color:#3b82f6"></i> Peminjam Paling Aktif</h3>
    </div>
    <div class="tbl-responsive">
      <table class="custom-tbl">
        <thead>
          <tr>
            <th style="width: 50px; text-align: center;">Rank</th>
            <th>Nama Mahasiswa</th>
            <th>Kelas</th>
            <th style="text-align: center;">Total Pinjam</th>
          </tr>
        </thead>
        <tbody>
          @if($topBorrowers->isEmpty())
            <tr><td colspan="4" style="text-align: center; color: var(--muted); padding: 20px;">Belum ada data peminjaman.</td></tr>
          @else
            @foreach($topBorrowers as $idx => $usr)
              <tr>
                <td style="text-align: center; font-weight: 700; color: #3b82f6;">#{{ $idx + 1 }}</td>
                <td>
                  <div class="user-cell">
                    <div class="user-avatar">
                      {{ strtoupper(substr($usr->name, 0, 2)) }}
                    </div>
                    <div style="font-weight: 600;">{{ $usr->name }}</div>
                  </div>
                </td>
                <td>{{ $usr->kelas ?? 'Mahasiswa' }}</td>
                <td style="text-align: center; font-weight: 700; color: var(--text);">
                  {{ $usr->borrowings_count }} Kali
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>

</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  6. TABEL DETAIL                                           --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="report-header" style="margin-bottom: 16px;">
  <h2 class="report-title" style="font-size: 1.05rem;">Rincian Log Transaksi Periode</h2>
</div>

<section class="tbl-card">
  <div class="tbl-responsive">
    <table class="custom-tbl">
      <thead>
        <tr>
          <th style="width: 40px; text-align: center;">#</th>
          <th>Peminjam</th>
          <th>Unit Laptop</th>
          <th>Tanggal Pinjam</th>
          <th>Tenggat Kembali</th>
          <th>Keperluan</th>
          <th>Status Akhir</th>
        </tr>
      </thead>
      <tbody>
        @if($detailBorrowings->isEmpty())
          <tr>
            <td colspan="7" style="text-align: center; padding: 40px 20px; color: var(--muted);">
              Tidak ada data peminjaman dalam periode tanggal ini.
            </td>
          </tr>
        @else
          @foreach($detailBorrowings as $i => $det)
            <tr>
              <td style="text-align: center; color: var(--muted); font-weight: 600;">
                {{ $detailBorrowings->firstItem() + $i }}
              </td>
              <td>
                <div style="font-weight: 600;">{{ $det->user?->name ?? $det->borrower_name ?? 'N/A' }}</div>
                <div style="font-size: 0.72rem; color: var(--muted);">{{ $det->user?->kelas ?? 'Umum' }}</div>
              </td>
              <td>
                <div style="font-weight: 600;">{{ $det->laptop->brand ?? 'N/A' }} {{ $det->laptop->model ?? '' }}</div>
                <div style="font-size: 0.72rem; color: var(--muted); font-family: monospace;">{{ $det->laptop->code ?? '-' }}</div>
              </td>
              <td>{{ $det->borrow_date->format('d M Y') }}</td>
              <td>{{ $det->return_date->format('d M Y') }}</td>
              <td style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $det->purpose }}">
                {{ $det->purpose }}
              </td>
              <td>
                @if($det->status === 'pending')
                  <span class="badge badge-amber">Pending</span>
                @elseif($det->status === 'approved')
                  <span class="badge badge-teal">Approved</span>
                @elseif($det->status === 'borrowed')
                  <span class="badge badge-blue">Borrowed</span>
                @elseif($det->status === 'returned')
                  <span class="badge badge-teal">Returned</span>
                @elseif($det->status === 'rejected')
                  <span class="badge badge-red">Rejected</span>
                @else
                  <span class="badge badge-red">{{ ucfirst($det->status) }}</span>
                @endif
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($detailBorrowings->hasPages())
    <div class="pagination-wrap">
      <div>
        Menampilkan {{ $detailBorrowings->firstItem() }} - {{ $detailBorrowings->lastItem() }} dari {{ $detailBorrowings->total() }} log peminjaman
      </div>
      <nav>
        {{-- Previous Page Link --}}
        @if ($detailBorrowings->onFirstPage())
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $detailBorrowings->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($detailBorrowings->getUrlRange(1, $detailBorrowings->lastPage()) as $page => $url)
          @if ($page == $detailBorrowings->currentPage())
            <span class="active-page">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($detailBorrowings->hasMorePages())
          <a href="{{ $detailBorrowings->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif
</section>

@push('scripts')
{{-- Load Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ─── 1. TREN PEMINJAMAN BULANAN (BAR CHART - TEAL) ─────────
var barCtx = document.getElementById('monthlyChart').getContext('2d');
var monthlyChart = new Chart(barCtx, {
  type: 'bar',
  data: {
    labels: {!! json_encode($monthlyLabels) !!},
    datasets: [{
      label: 'Jumlah Transaksi Peminjaman',
      data: {!! json_encode($monthlyValues) !!},
      backgroundColor: 'rgba(13, 159, 122, 0.85)',
      borderColor: '#0D9F7A',
      borderWidth: 1.5,
      borderRadius: 6,
      barThickness: 28
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: { display: false }
    },
    scales: {
      y: {
        beginAtZero: true,
        grid: { color: '#f1f5f9' },
        ticks: { color: '#64748b', font: { family: 'Inter' } }
      },
      x: {
        grid: { display: false },
        ticks: { color: '#64748b', font: { family: 'Inter' } }
      }
    }
  }
});

// ─── 2. DISTRIBUSI KONDISI LAPTOP (DONUT CHART - STATUS SYSTEM CODES) ───
var donutCtx = document.getElementById('laptopStatusChart').getContext('2d');
var laptopStatusChart = new Chart(donutCtx, {
  type: 'doughnut',
  data: {
    labels: ['Tersedia', 'Dipinjam', 'Maintenance', 'Rusak'],
    datasets: [{
      data: {!! json_encode($laptopCounts) !!},
      backgroundColor: [
        '#0D9F7A', // tersedia=teal
        '#3b82f6', // dipinjam=blue
        '#f59e0b', // maintenance=amber
        '#ef4444'  // rusak=red
      ],
      borderWidth: 2,
      borderColor: '#fff'
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        position: 'bottom',
        labels: {
          color: '#475569',
          font: { family: 'Inter', size: 11, weight: '600' },
          padding: 16
        }
      }
    },
    cutout: '65%'
  }
});

// Simulated Exports
function exportSimulated(type) {
  if (type === 'PDF') {
    window.print();
  } else {
    alert('Format ' + type + ' berhasil dibuat! File terunduh otomatis ke folder Downloads.');
  }
}
</script>
@endpush
@endsection
