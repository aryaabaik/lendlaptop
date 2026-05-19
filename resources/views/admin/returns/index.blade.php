@extends('layouts.admin')

@section('title', 'Pengembalian Laptop')
@section('page_title', 'Pengembalian Laptop')
@section('breadcrumb')
  <span>Pengembalian</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM RETURNS STYLE ───────────────────────────────── */
.returns-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
}
.returns-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text);
}

/* Filter Bar */
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
  grid-template-columns: 3fr 1fr;
  gap: 16px;
  align-items: flex-end;
}
@media(max-width: 767px) {
  .filter-grid {
    grid-template-columns: 1fr;
  }
}

/* Custom form components */
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
.f-input:focus {
  border-color: var(--teal);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(13,159,122,.12);
}
.f-select {
  width: 100%;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 8.5px 14px;
  font-family: 'Inter', sans-serif;
  font-size: .82rem;
  color: var(--text);
  outline: none;
  cursor: pointer;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 12px;
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
  padding: 14px 18px;
  background: #f8fafc;
  color: var(--muted);
  font-weight: 600;
  text-transform: uppercase;
  font-size: .7rem;
  letter-spacing: .05em;
  border-bottom: 1px solid var(--border);
}
.custom-tbl td {
  padding: 14px 18px;
  border-bottom: 1px solid #f1f5f9;
  color: var(--text);
  vertical-align: middle;
}
.custom-tbl tr:last-child td {
  border-bottom: none;
}

/* Highlight late rows */
.row-late-returned {
  background-color: rgba(245, 158, 11, 0.04) !important; /* bg-amber-50 */
}
.row-late-returned td {
  border-bottom-color: rgba(245, 158, 11, 0.08) !important;
}

/* User & Laptop Cell Details */
.user-cell {
  display: flex;
  align-items: center;
  gap: 10px;
}
.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: var(--teal-dim);
  color: var(--teal);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: .75rem;
}
.laptop-cell {
  display: flex;
  align-items: center;
  gap: 10px;
}
.laptop-thumb {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: #f8fafc;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--teal);
  font-size: 1rem;
}
.laptop-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 7px;
}

/* Action button configurations */
.act-btn {
  padding: 6px 12px;
  font-size: .75rem;
  font-weight: 600;
  border-radius: 8px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  border: none;
  text-decoration: none;
  transition: all .15s ease;
  background: #f1f5f9;
  color: var(--muted);
}
.act-btn:hover {
  background: #cbd5e1;
  color: var(--text);
}

/* Fine formatting */
.fine-red {
  color: #dc2626; /* text-red-600 */
  font-weight: 600;
}

/* Modals design */
.modal {
  position: fixed;
  inset: 0;
  z-index: 1000;
  background: rgba(10,22,40,.5);
  backdrop-filter: blur(4px);
  display: none;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
.modal.show {
  display: flex;
}
.modal-content {
  background: #fff;
  border-radius: 1rem;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 20px 25px -5px rgba(0,0,0,.15);
  overflow: hidden;
  animation: modalPop .25s ease;
}
@keyframes modalPop {
  from { transform: scale(.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.modal-header {
  padding: 16px 20px;
  background: #f8fafc;
  border-bottom: 1px solid #cbd5e1;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-title {
  font-weight: 700;
  font-size: .95rem;
  color: var(--text);
}
.modal-close {
  background: none;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: var(--muted);
}
.modal-body {
  padding: 20px;
}
.modal-footer {
  padding: 14px 20px;
  background: #f8fafc;
  border-top: 1px solid #cbd5e1;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}

/* Pagination Override */
.pagination-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-top: 1px solid #f1f5f9;
  background: #fff;
  font-size: .8rem;
}
.pagination-wrap nav {
  display: inline-flex;
  border-radius: 8px;
  overflow: hidden;
}
.pagination-wrap span, .pagination-wrap a {
  padding: 8px 14px;
  border: 1px solid #cbd5e1;
  background: #fff;
  color: var(--muted);
  text-decoration: none;
  font-weight: 500;
  transition: all .2s;
  margin-left: -1px;
}
.pagination-wrap a:hover {
  background: #f8fafc;
  color: var(--text);
}
.pagination-wrap .active-page {
  background: var(--teal) !important;
  color: #fff !important;
  border-color: var(--teal) !important;
}
</style>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  1. HEADER                                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="returns-header">
  <h1 class="returns-title">Pengembalian Laptop</h1>
  <button class="btn btn-primary" onclick="openReturnModal()">
    <i class="ti ti-plus"></i> Proses Pengembalian
  </button>
</div>

{{-- Filter Card --}}
<section class="filter-card">
  <form method="GET" action="{{ route('admin.returns.index') }}">
    <div class="filter-grid">
      
      {{-- Search --}}
      <div>
        <label class="f-label">Cari Pengembalian</label>
        <div class="f-input-wrapper">
          <i class="ti ti-search"></i>
          <input type="text" name="search" class="f-input" value="{{ request('search') }}" placeholder="Cari nama mahasiswa / kode laptop...">
        </div>
      </div>

      {{-- Actions --}}
      <div class="filter-actions">
        <button type="submit" class="btn btn-primary" style="padding: 9px 18px; width: 100%;">
          <i class="ti ti-filter"></i> Cari
        </button>
      </div>

    </div>
  </form>
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  2. TABEL (card)                                           --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="tbl-card">
  <div class="tbl-responsive">
    @if($returns->isEmpty())
      <div style="text-align: center; padding: 50px 20px; color: var(--muted);">
        <i class="ti ti-history-toggle" style="font-size: 3rem; margin-bottom: 12px; display: block; opacity: 0.5;"></i>
        Belum ada catatan log pengembalian laptop.
      </div>
    @else
      <table class="custom-tbl">
        <thead>
          <tr>
            <th style="width: 40px; text-align: center;">#</th>
            <th>Peminjam</th>
            <th>Laptop</th>
            <th>Tgl Kembali Rencana</th>
            <th>Tgl Kembali Aktual</th>
            <th>Kondisi Setelah</th>
            <th>Denda</th>
            <th style="max-width: 200px;">Catatan</th>
            <th style="text-align: center; width: 100px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($returns as $i => $ret)
            @php
              // Cek terlambat pada saat pengembalian
              $actual = $ret->borrowing->actual_return_date;
              $rencana = $ret->borrowing->return_date;
              $isLateReturned = ($actual && $actual->gt($rencana));
            @endphp
            <tr class="{{ $isLateReturned ? 'row-late-returned' : '' }}">
              <td style="text-align: center; color: var(--muted); font-weight: 600;">
                {{ $returns->firstItem() + $i }}
              </td>
              <td>
                <div class="user-cell">
                  <div class="user-avatar">
                    {{ strtoupper(substr($ret->borrowing->user?->name ?? $ret->borrowing->borrower_name ?? 'U', 0, 2)) }}
                  </div>
                  <div>
                    <div style="font-weight: 600;">{{ $ret->borrowing->user?->name ?? $ret->borrowing->borrower_name ?? 'N/A' }}</div>
                    <div style="font-size: .72rem; color: var(--muted);">{{ $ret->borrowing->user?->kelas ?? 'Umum' }}</div>
                  </div>
                </div>
              </td>
              <td>
                <div class="laptop-cell">
                  <div class="laptop-thumb">
                    @if($ret->borrowing->laptop && $ret->borrowing->laptop->image)
                      <img src="{{ asset('storage/' . $ret->borrowing->laptop->image) }}" alt="Laptop thumbnail">
                    @else
                      <i class="ti ti-device-laptop"></i>
                    @endif
                  </div>
                  <div>
                    <div style="font-weight: 600;">{{ $ret->borrowing->laptop->brand ?? 'N/A' }}</div>
                    <div style="font-size: .72rem; color: var(--muted); font-family: monospace;">{{ $ret->borrowing->laptop->code ?? 'N/A' }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $rencana->format('d M Y') }}</td>
              <td>
                <div style="{{ $isLateReturned ? 'color:var(--amber); font-weight:700;' : '' }}">
                  {{ $actual ? $actual->format('d M Y') : 'N/A' }}
                  @if($isLateReturned)
                    <div style="font-size: 0.65rem; text-transform: uppercase;"><i class="ti ti-alert-triangle"></i> Terlambat</div>
                  @endif
                </div>
              </td>
              <td>
                @if($ret->condition_after === 'baik')
                  <span class="badge badge-teal">Baik</span>
                @elseif($ret->condition_after === 'rusak_ringan')
                  <span class="badge badge-amber">Rusak Ringan</span>
                @else
                  <span class="badge badge-red">Rusak Berat</span>
                @endif
              </td>
              <td>
                @if($ret->fine > 0)
                  <span class="fine-red">Rp {{ number_format($ret->fine, 0, ',', '.') }}</span>
                @else
                  <span style="color:var(--muted)">Rp 0</span>
                @endif
              </td>
              <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $ret->note }}">
                {{ $ret->note ?? '-' }}
              </td>
              <td>
                <div style="text-align: center;">
                  <a href="{{ route('admin.borrowings.show', $ret->borrowing_id) }}" class="act-btn" title="Detail Transaksi">
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

  {{-- PAGINATION --}}
  @if($returns->hasPages())
    <div class="pagination-wrap">
      <div>
        Menampilkan {{ $returns->firstItem() }} - {{ $returns->lastItem() }} dari {{ $returns->total() }} data
      </div>
      <nav>
        {{-- Previous Page Link --}}
        @if ($returns->onFirstPage())
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $returns->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($returns->getUrlRange(1, $returns->lastPage()) as $page => $url)
          @if ($page == $returns->currentPage())
            <span class="active-page">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($returns->hasMorePages())
          <a href="{{ $returns->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  4. FORM PENGEMBALIAN (modal)                              --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="modal" id="returnModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Proses Pengembalian Baru</h3>
      <button class="modal-close" onclick="closeReturnModal()">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.returns.store') }}">
      @csrf
      <div class="modal-body">
        
        {{-- Peminjaman Aktif --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Pilih Transaksi Peminjaman Aktif</label>
          <select name="borrowing_id" id="borrowing_select" class="f-select" required onchange="calculateDenda()">
            <option value="">Pilih Transaksi...</option>
            @foreach($active_borrowings as $b)
              @php
                // Hitung denda awal jika lewat hari
                $tenggat = $b->return_date;
                $diffDays = now()->diffInDays($tenggat, false);
                $isLate = $diffDays < 0;
                $lateDays = $isLate ? abs($diffDays) : 0;
              @endphp
              <option value="{{ $b->id }}" 
                      data-user="{{ $b->user?->name ?? $b->borrower_name }}" 
                      data-laptop="{{ $b->laptop?->brand ?? 'N/A' }} {{ $b->laptop?->model ?? '' }}"
                      data-late-days="{{ $lateDays }}">
                {{ $b->user?->name ?? $b->borrower_name }} - {{ $b->laptop?->brand ?? 'N/A' }} {{ $b->laptop?->model ?? '' }} (Tenggat: {{ $b->return_date?->format('d M Y') }})
                @if($isLate)
                  [Terlambat {{ $lateDays }} Hari]
                @endif
              </option>
            @endforeach
          </select>
        </div>

        {{-- Kondisi Setelah Kembali --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Kondisi Setelah Dikembalikan</label>
          <select name="condition_after" class="f-select" required>
            <option value="baik">Baik (Tersedia kembali)</option>
            <option value="rusak_ringan">Rusak Ringan (Maintenance)</option>
            <option value="rusak_berat">Rusak Berat (Rusak)</option>
          </select>
        </div>

        {{-- Denda input --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Denda Keterlambatan (Rp)</label>
          <div class="f-input-wrapper">
            <i class="ti ti-wallet"></i>
            <input type="number" name="fine" id="return_fine" class="f-input" placeholder="0" min="0" value="0">
          </div>
          <p id="fine-helper" style="font-size: 0.72rem; color: var(--muted); margin-top: 4px; display: none; font-weight: 500;"></p>
        </div>

        {{-- Catatan --}}
        <div class="field" style="margin-bottom: 0;">
          <label class="f-label">Catatan Pengembalian</label>
          <textarea name="note" class="f-input" style="height: 80px; padding: 10px; resize: none;" placeholder="Tuliskan catatan kondisi fisik laptop secara detail..."></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeReturnModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Konfirmasi Pengembalian</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
// Open/Close Return Modal
function openReturnModal() {
  document.getElementById('returnModal').classList.add('show');
}
function closeReturnModal() {
  document.getElementById('returnModal').classList.remove('show');
}

// Auto calculate denda
function calculateDenda() {
  var sel = document.getElementById('borrowing_select');
  var opt = sel.options[sel.selectedIndex];
  var helper = document.getElementById('fine-helper');
  var fineInput = document.getElementById('return_fine');
  
  if (!opt || opt.value === '') {
    fineInput.value = 0;
    helper.style.display = 'none';
    return;
  }
  
  var lateDays = parseInt(opt.getAttribute('data-late-days') || 0);
  if (lateDays > 0) {
    // Tarif denda per hari, contoh Rp 10.000 / hari
    var fineRate = 10000;
    var suggestedFine = lateDays * fineRate;
    
    fineInput.value = suggestedFine;
    helper.textContent = '* Terlambat ' + lateDays + ' hari. Denda disarankan Rp ' + suggestedFine.toLocaleString('id-ID') + ' (Rp 10.000 / hari)';
    helper.style.color = '#dc2626';
    helper.style.display = 'block';
  } else {
    fineInput.value = 0;
    helper.textContent = '* Tepat waktu. Tidak ada denda disarankan.';
    helper.style.color = 'var(--teal)';
    helper.style.display = 'block';
  }
}

// Form loader spinner
document.querySelectorAll('form').forEach(function(f){
  f.addEventListener('submit', function(){
    var btn = f.querySelector('.btn-primary');
    if(btn){
      btn.innerHTML = '<i class="ti ti-loader animate-spin"></i> Memproses...';
      btn.disabled = true;
      btn.style.opacity = '.75';
    }
  });
});
</script>
@endpush
@endsection
