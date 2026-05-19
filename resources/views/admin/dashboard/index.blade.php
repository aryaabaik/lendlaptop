@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Panel')
@section('breadcrumb')
  <span>Dashboard</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM DASHBOARD STYLE SYSTEM ───────────────────────── */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}
.stat-card {
  background: #fff;
  border-radius: 0.75rem; /* rounded-xl (12px) */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  padding: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 1px 3px rgba(0,0,0,.02), 0 1px 2px rgba(0,0,0,.01);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}
.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 20px -5px rgba(13,159,122,0.08);
}
.stat-info {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.stat-label {
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
.stat-value {
  font-size: 1.85rem;
  font-weight: 700;
  color: var(--text);
  line-height: 1.1;
}
.stat-icon-box {
  width: 52px;
  height: 52px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.6rem;
  transition: transform 0.3s;
}
.stat-card:hover .stat-icon-box {
  transform: scale(1.1) rotate(2deg);
}

/* Custom icon and glow themes */
.stat-teal .stat-icon-box { background: rgba(13,159,122,0.1); color: #0D9F7A; }
.stat-blue .stat-icon-box { background: rgba(59,130,246,0.1); color: #3B82F6; }
.stat-green .stat-icon-box { background: rgba(16,185,129,0.1); color: #10B981; }
.stat-amber .stat-icon-box { background: rgba(245,158,11,0.1); color: #F59E0B; }

.badge-alert {
  position: absolute;
  top: 14px;
  right: 14px;
  background: var(--red);
  color: #fff;
  font-size: 0.65rem;
  font-weight: 700;
  padding: 3px 8px;
  border-radius: 20px;
  box-shadow: 0 3px 6px rgba(239,68,68,0.25);
  animation: pulsePulse 2s infinite;
}
@keyframes pulsePulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.06); }
  100% { transform: scale(1); }
}

/* Full Width Card Styling */
.section-card {
  background: #fff;
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  padding: 24px;
  margin-bottom: 24px;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
}
.section-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 20px;
  padding-bottom: 12px;
  border-bottom: 1px solid #f9fafb;
}
.section-card-title {
  font-size: 0.95rem;
  font-weight: 700;
  color: var(--navy);
  display: flex;
  align-items: center;
  gap: 8px;
}
.section-card-title i {
  color: #0D9F7A;
  font-size: 1.2rem;
}

/* Day Pills Above Chart */
.pills-container {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 20px;
}
.pill-day {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 9999px;
  padding: 6px 14px;
  font-size: 0.78rem;
  color: var(--text);
  font-weight: 500;
  transition: all 0.2s ease;
  cursor: default;
}
.pill-day:hover {
  background: rgba(13,159,122,0.06);
  border-color: rgba(13,159,122,0.3);
  color: #0D9F7A;
  transform: translateY(-1px);
}
.pill-day.active {
  background: rgba(13,159,122,0.1);
  border-color: rgba(13,159,122,0.4);
  color: #0D9F7A;
  font-weight: 600;
}
.pill-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #0D9F7A;
  display: inline-block;
}

/* Tables styling */
.tbl-wrapper {
  width: 100%;
  overflow-x: auto;
}
.tbl-custom {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 0.82rem;
}
.tbl-custom th {
  padding: 12px 16px;
  background: #f9fafb;
  color: var(--muted);
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.7rem;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #f3f4f6;
}
.tbl-custom td {
  padding: 14px 16px;
  border-bottom: 1px solid #f9fafb;
  color: var(--text);
  vertical-align: middle;
}
.tbl-custom tr:last-child td {
  border-bottom: none;
}

/* Overdue amber highlighting */
.tbl-custom tr.row-late {
  background-color: #fffbeb !important; /* Soft Amber Background */
  border-left: 4px solid #F59E0B;
  transition: background-color 0.2s;
}
.tbl-custom tr.row-late td {
  border-bottom-color: #fef3c7;
}

/* User cell info */
.borrower-info {
  display: flex;
  align-items: center;
  gap: 10px;
}
.borrower-avatar {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: rgba(13,159,122,0.1);
  color: #0D9F7A;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.75rem;
}

/* Action button system */
.btn-group-action {
  display: flex;
  align-items: center;
  gap: 8px;
}
.btn-act {
  padding: 6px 12px;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: 6px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  border: none;
  text-decoration: none;
  transition: all 0.15s ease;
}
.btn-act-approve {
  background: rgba(13,159,122,0.1);
  color: #0D9F7A;
}
.btn-act-approve:hover {
  background: #0D9F7A;
  color: #fff;
  box-shadow: 0 4px 8px rgba(13,159,122,0.2);
}
.btn-act-reject {
  background: rgba(239,68,68,0.08);
  color: var(--red);
}
.btn-act-reject:hover {
  background: var(--red);
  color: #fff;
  box-shadow: 0 4px 8px rgba(239,68,68,0.2);
}
.btn-act-detail {
  background: #f1f5f9;
  color: var(--muted);
}
.btn-act-detail:hover {
  background: #cbd5e1;
  color: var(--text);
}

/* Status Badges */
.status-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 10px;
  border-radius: 9999px;
  font-size: 0.7rem;
  font-weight: 600;
  line-height: 1.5;
}
.status-badge-pending { background: rgba(245,158,11,0.1); color: #92400e; }
.status-badge-borrowed { background: rgba(59,130,246,0.1); color: #1d4ed8; }
.status-badge-returned { background: rgba(13,159,122,0.1); color: #0b7a5e; }
.status-badge-rejected { background: rgba(239,68,68,0.1); color: #b91c1c; }

/* Rejection Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 1000;
  background: rgba(10,22,40,0.5);
  backdrop-filter: blur(4px);
  display: none;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
.modal-overlay.show {
  display: flex;
}
.modal-card {
  background: #fff;
  border-radius: 0.75rem; /* rounded-xl */
  width: 100%;
  max-width: 460px;
  box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
  overflow: hidden;
  animation: modalScaleUp 0.25s ease-out;
}
@keyframes modalScaleUp {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.modal-card-header {
  padding: 16px 20px;
  background: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-card-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: var(--navy);
}
.modal-card-close {
  background: none;
  border: none;
  font-size: 1.25rem;
  cursor: pointer;
  color: var(--muted);
  line-height: 1;
}
.modal-card-body {
  padding: 20px;
}
.modal-card-footer {
  padding: 14px 20px;
  background: #f9fafb;
  border-top: 1px solid #e5e7eb;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}
.input-block {
  margin-bottom: 16px;
}
.label-block {
  display: block;
  font-size: 0.78rem;
  font-weight: 600;
  color: var(--text);
  margin-bottom: 6px;
}
.textarea-styled {
  width: 100%;
  background: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 14px;
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  resize: none;
  height: 100px;
  color: var(--text);
  transition: border-color 0.15s;
}
.textarea-styled:focus {
  outline: none;
  border-color: #0D9F7A;
  background: #fff;
}
.btn-styled-primary {
  background: #0D9F7A; /* bg-[#0D9F7A] */
  color: #fff;
  border: none;
  border-radius: 0.5rem;
  padding: 8px 16px;
  font-weight: 600;
  font-size: 0.8rem;
  cursor: pointer;
  transition: background-color 0.15s;
}
.btn-styled-primary:hover {
  background: #0b8a6a; /* hover:bg-[#0b8a6a] */
}
.btn-styled-secondary {
  background: #f3f4f6;
  color: var(--muted);
  border: none;
  border-radius: 0.5rem;
  padding: 8px 16px;
  font-weight: 600;
  font-size: 0.8rem;
  cursor: pointer;
}
.btn-styled-secondary:hover {
  background: #e5e7eb;
}
</style>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  1. STAT CARDS (grid 4 kolom)                              --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="stats-grid">
  
  {{-- Total Laptop --}}
  <div class="stat-card stat-teal">
    <div class="stat-info">
      <span class="stat-label">Total Laptop</span>
      <span class="stat-value">{{ $stats['total_laptops'] }}</span>
    </div>
    <div class="stat-icon-box">
      <i class="ti ti-device-laptop"></i>
    </div>
  </div>

  {{-- Sedang Dipinjam --}}
  <div class="stat-card stat-blue">
    <div class="stat-info">
      <span class="stat-label">Sedang Dipinjam</span>
      <span class="stat-value">{{ $stats['borrowed_count'] }}</span>
    </div>
    <div class="stat-icon-box">
      <i class="ti ti-clock"></i>
    </div>
  </div>

  {{-- Dikembalikan Hari Ini --}}
  <div class="stat-card stat-green">
    <div class="stat-info">
      <span class="stat-label">Dikembalikan Hari Ini</span>
      <span class="stat-value">{{ $stats['returned_today_count'] }}</span>
    </div>
    <div class="stat-icon-box">
      <i class="ti ti-clipboard-check"></i>
    </div>
  </div>

  {{-- Menunggu Approve --}}
  <div class="stat-card stat-amber">
    @if($stats['pending_count'] > 0)
      <span class="badge-alert">{{ $stats['pending_count'] }}</span>
    @endif
    <div class="stat-info">
      <span class="stat-label">Menunggu Approve</span>
      <span class="stat-value">{{ $stats['pending_count'] }}</span>
    </div>
    <div class="stat-icon-box">
      <i class="ti ti-bell"></i>
    </div>
  </div>

</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  2. BAR CHART "Peminjaman per Hari"                        --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="section-card">
  <div class="section-card-header">
    <h2 class="section-card-title">
      <i class="ti ti-chart-bar"></i> Peminjaman per Hari
    </h2>
  </div>

  {{-- Interactive day pills above the chart --}}
  <div class="pills-container">
    @foreach($borrowingsByDay as $dayData)
      <div class="pill-day @if($dayData->total > 0) active @endif">
        <span class="pill-dot"></span>
        <strong>{{ $dayData->day }}:</strong> {{ $dayData->total }} peminjaman
      </div>
    @endforeach
  </div>

  {{-- Chart canvas --}}
  <div style="position: relative; height: 280px; width: 100%;">
    <canvas id="weeklyBorrowingsChart"></canvas>
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  3. TABEL PEMINJAMAN HARI INI                              --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="section-card">
  <div class="section-card-header">
    <h2 class="section-card-title">
      <i class="ti ti-clipboard-list"></i> Peminjaman Hari Ini & Overdue
    </h2>
    <a href="{{ route('admin.borrowings.index') }}" class="btn-act btn-act-detail" style="text-decoration: none;">
      Semua Data Peminjaman <i class="ti ti-chevron-right"></i>
    </a>
  </div>

  <div class="tbl-wrapper">
    @if($todayBorrowings->isEmpty())
      <div style="text-align: center; padding: 40px 20px; color: var(--muted);">
        <i class="ti ti-clipboard-off" style="font-size: 2.5rem; margin-bottom: 12px; display: block; opacity: 0.5;"></i>
        Tidak ada data transaksi peminjaman hari ini.
      </div>
    @else
      <table class="tbl-custom">
        <thead>
          <tr>
            <th>Nama Peminjam</th>
            <th>Laptop</th>
            <th>Keperluan</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th style="text-align: center;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($todayBorrowings as $b)
            <tr class="@if($b->isLate()) row-late @endif">
              <td>
                <div class="borrower-info">
                  <div class="borrower-avatar">
                    {{ strtoupper(substr($b->borrower_name ?? 'U', 0, 2)) }}
                  </div>
                  <div>
                    <div style="font-weight: 600;">{{ $b->borrower_name ?? 'N/A' }}</div>
                    <div style="font-size: 0.72rem; color: var(--muted);">
                      {{ $b->user ? ($b->user->kelas ?? 'Mahasiswa') : 'Umum' }}
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div style="font-weight: 600;">{{ $b->laptop->brand ?? 'N/A' }}</div>
                <div style="font-size: 0.72rem; color: var(--muted);">{{ $b->laptop->model ?? 'N/A' }}</div>
              </td>
              <td>{{ $b->purpose }}</td>
              <td>
                <div style="font-weight: 600;">{{ $b->return_date->format('d M Y') }}</div>
                @if($b->isLate())
                  <div style="font-size: 0.7rem; color: #b45309; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                    <i class="ti ti-alert-triangle" style="font-size: 0.8rem;"></i> Terlambat
                  </div>
                @endif
              </td>
              <td>
                @if($b->status === 'pending')
                  <span class="status-badge status-badge-pending">Menunggu</span>
                @elseif($b->status === 'borrowed')
                  <span class="status-badge status-badge-borrowed">Dipinjam</span>
                @elseif($b->status === 'returned')
                  <span class="status-badge status-badge-returned">Kembali</span>
                @elseif($b->status === 'rejected')
                  <span class="status-badge status-badge-rejected">Ditolak</span>
                @else
                  <span class="status-badge status-badge-borrowed">{{ ucfirst($b->status) }}</span>
                @endif
              </td>
              <td>
                <div class="btn-group-action" style="justify-content: center;">
                  @if($b->status === 'pending')
                    {{-- Quick Approve --}}
                    <form method="POST" action="{{ route('admin.borrowings.approve', $b->id) }}" style="display:inline;">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn-act btn-act-approve" title="Setujui Peminjaman">
                        <i class="ti ti-check"></i> Approve
                      </button>
                    </form>
                    
                    {{-- Quick Reject --}}
                    <button type="button" class="btn-act btn-act-reject" onclick="openRejectModal({{ $b->id }}, '{{ $b->borrower_name }}')" title="Tolak Peminjaman">
                      <i class="ti ti-x"></i> Reject
                    </button>
                  @endif

                  {{-- View Detail --}}
                  <a href="{{ route('admin.borrowings.show', $b->id) }}" class="btn-act btn-act-detail" title="Detail Peminjaman">
                    <i class="ti ti-eye"></i> Detail
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  MODAL PENOLAKAN PEMINJAMAN                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="rejectionModalOverlay">
  <div class="modal-card">
    <div class="modal-card-header">
      <h3 class="modal-card-title">Tolak Peminjaman Laptop</h3>
      <button class="modal-card-close" onclick="closeRejectModal()">&times;</button>
    </div>
    <form id="rejectionForm" method="POST" action="">
      @csrf
      @method('PATCH')
      <div class="modal-card-body">
        <p style="margin-bottom: 16px; font-size: 0.82rem; color: var(--muted); line-height: 1.4;">
          Anda akan menolak pengajuan peminjaman dari peminjam <strong id="rejectionTargetName" style="color: var(--text);"></strong>. Silakan masukkan alasan penolakan di bawah ini:
        </p>
        
        <div class="input-block">
          <label class="label-block" for="admin_note">Alasan Penolakan</label>
          <textarea id="admin_note" name="admin_note" class="textarea-styled" placeholder="Masukkan alasan penolakan, misal: Laptop sedang dalam perbaikan..." required></textarea>
        </div>
      </div>
      <div class="modal-card-footer">
        <button type="button" class="btn-styled-secondary" onclick="closeRejectModal()">Batal</button>
        <button type="submit" class="btn-styled-primary" style="background: var(--red); color: white;">Tolak Peminjaman</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
{{-- Chart.js CDN via JSDelivr --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// --- Rejection Modal Management ---
function openRejectModal(borrowingId, borrowerName) {
  var form = document.getElementById('rejectionForm');
  form.action = '/admin/borrowings/' + borrowingId + '/reject';
  
  document.getElementById('rejectionTargetName').textContent = borrowerName;
  document.getElementById('rejectionModalOverlay').classList.add('show');
  document.getElementById('admin_note').focus();
}

function closeRejectModal() {
  document.getElementById('rejectionModalOverlay').classList.remove('show');
}

// --- Chart.js Weekly Configuration ---
document.addEventListener('DOMContentLoaded', function() {
  var ctx = document.getElementById('weeklyBorrowingsChart').getContext('2d');
  
  // Prepare daily data
  var chartLabels = @json($borrowingsByDay->pluck('day'));
  var chartTotals = @json($borrowingsByDay->pluck('total'));

  var weeklyChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: chartLabels,
      datasets: [{
        label: 'Jumlah Peminjaman',
        data: chartTotals,
        backgroundColor: '#0D9F7A',
        hoverBackgroundColor: '#0b8a6a',
        borderRadius: 8, // Rounded bars
        borderSkipped: false,
        barThickness: 36
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false // We use our premium daily pill indicators above
        },
        tooltip: {
          enabled: true,
          backgroundColor: '#0A1628',
          titleColor: '#fff',
          titleFont: {
            family: 'Inter',
            weight: 'bold',
            size: 12
          },
          bodyColor: '#fff',
          bodyFont: {
            family: 'Inter',
            size: 12
          },
          padding: 12,
          cornerRadius: 8,
          displayColors: false,
          callbacks: {
            label: function(context) {
              return context.raw + ' Laptop Dipinjam';
            }
          }
        }
      },
      scales: {
        x: {
          grid: {
            display: false
          },
          ticks: {
            color: '#64748b',
            font: {
              family: 'Inter',
              size: 11,
              weight: '500'
            }
          }
        },
        y: {
          grid: {
            color: '#f3f4f6',
            drawBorder: false
          },
          ticks: {
            color: '#64748b',
            stepSize: 1,
            precision: 0,
            font: {
              family: 'Inter',
              size: 11
            }
          }
        }
      }
    }
  });
});
</script>
@endpush
@endsection
