@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<style>
/* ─── PREMIUM HISTORY PAGE STYLES ─────────────────────────── */
.history-container {
  max-width: 900px;
  margin: 104px auto 40px;
  padding: 0 24px;
}

/* Header */
.h-header {
  margin-bottom: 24px;
}
.h-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text);
  letter-spacing: -0.02em;
}

/* 1. Summary Cards (3 Columns) */
.summary-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 30px;
}
@media(max-width: 767px) {
  .summary-grid {
    grid-template-columns: 1fr;
  }
}
.sum-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  transition: transform .2s;
}
.sum-card:hover {
  transform: translateY(-2px);
}
.sum-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  flex-shrink: 0;
}
.sum-num {
  font-size: 1.35rem;
  font-weight: 700;
  color: var(--text);
  line-height: 1.2;
}
.sum-lbl {
  font-size: .75rem;
  color: var(--muted);
  font-weight: 600;
  margin-top: 2px;
}

/* 2. Filter Section Card */
.filter-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 20px;
  margin-bottom: 24px;
}
.filter-title {
  font-size: .82rem;
  font-weight: 700;
  color: var(--text);
  text-transform: uppercase;
  letter-spacing: .05em;
  margin-bottom: 16px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.filter-row {
  display: grid;
  grid-template-columns: 2fr 2.5fr 1.5fr auto;
  gap: 16px;
  align-items: end;
}
@media(max-width: 991px) {
  .filter-row {
    grid-template-columns: 1fr 1fr;
  }
}
@media(max-width: 575px) {
  .filter-row {
    grid-template-columns: 1fr;
  }
}

.f-label {
  display: block;
  font-size: .75rem;
  font-weight: 700;
  color: var(--muted);
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: .02em;
}
.f-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.f-input-wrapper i {
  position: absolute;
  left: 12px;
  color: #94a3b8;
  font-size: 1rem;
  pointer-events: none;
}
.f-input {
  width: 100%;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 8.5px 12px 8.5px 36px;
  font-family: 'Inter', sans-serif;
  font-size: .8rem;
  color: var(--text);
  outline: none;
  transition: all .2s ease;
}
.f-input:focus {
  border-color: var(--teal);
  background: #fff;
  box-shadow: 0 0 0 3px rgba(13,159,122,.12);
}

.range-inputs {
  display: flex;
  align-items: center;
  gap: 8px;
}

/* 3. Timeline / Card list */
.history-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 24px;
}
.hist-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 20px;
  display: flex;
  flex-direction: column;
  transition: all .2s;
}
.hist-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(10,22,40,.04);
}

.hist-top {
  display: grid;
  grid-template-columns: auto 1fr auto;
  gap: 16px;
  align-items: center;
}
@media(max-width: 575px) {
  .hist-top {
    grid-template-columns: 1fr;
    text-align: center;
    justify-items: center;
  }
}

.hist-thumb {
  width: 56px;
  height: 56px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: #f8fafc;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--teal);
  font-size: 1.35rem;
  flex-shrink: 0;
}
.hist-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 7px;
}

.hist-lap-name {
  font-weight: 700;
  font-size: .92rem;
  color: var(--text);
}
.hist-lap-code {
  font-family: monospace;
  font-size: .74rem;
  color: var(--muted);
  margin-top: 1px;
}

.hist-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 6px;
}
@media(max-width: 575px) {
  .hist-right {
    align-items: center;
  }
}

/* Hist Grid Details */
.hist-details-row {
  margin-top: 14px;
  padding-top: 12px;
  border-top: 1px solid #f1f5f9;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 12px;
}
@media(max-width: 767px) {
  .hist-details-row {
    grid-template-columns: 1fr 1fr;
    gap: 16px;
  }
}
.detail-item-col {
  display: flex;
  flex-direction: column;
}
.detail-item-lbl {
  font-size: .68rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: .02em;
  margin-bottom: 4px;
}
.detail-item-val {
  font-size: .78rem;
  font-weight: 700;
  color: var(--text);
}

.hist-bottom-actions {
  margin-top: 14px;
  padding-top: 12px;
  border-top: 1px solid #f1f5f9;
  display: flex;
  justify-content: flex-end;
}

/* Pagination Wrap */
.pagination-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-radius: 1rem;
  background: #fff;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
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

<div class="history-container">
  
  {{-- Header --}}
  <div class="h-header">
    <h1 class="h-title">Riwayat Peminjaman</h1>
  </div>

  {{-- 1. Summary Cards (3 Columns) --}}
  <section class="summary-grid">
    
    {{-- Total Transaksi --}}
    <div class="sum-card">
      <div class="sum-icon" style="background: rgba(13, 159, 122, 0.08); color: var(--teal);">
        <i class="ti ti-clipboard-list"></i>
      </div>
      <div>
        <div class="sum-num">{{ $totalBorrowingsCount }}</div>
        <div class="sum-lbl">Total Transaksi</div>
      </div>
    </div>

    {{-- Total Durasi Sewa --}}
    <div class="sum-card">
      <div class="sum-icon" style="background: rgba(59, 130, 246, 0.08); color: #3b82f6;">
        <i class="ti ti-calendar-time"></i>
      </div>
      <div>
        <div class="sum-num">{{ $totalDays }} hari</div>
        <div class="sum-lbl">Total Masa Pinjam</div>
      </div>
    </div>

    {{-- Total Denda --}}
    <div class="sum-card">
      <div class="sum-icon" style="background: rgba(239, 68, 68, 0.08); color: var(--red);">
        <i class="ti ti-receipt-refund"></i>
      </div>
      <div>
        <div class="sum-num">Rp {{ number_format($totalFines, 0, ',', '.') }}</div>
        <div class="sum-lbl">Total Denda</div>
      </div>
    </div>

  </section>

  {{-- 2. Filter Section Card --}}
  <section class="filter-card">
    <div class="filter-title">
      <i class="ti ti-adjustments-horizontal"></i> Saring Riwayat
    </div>
    <form method="GET" action="{{ route('user.history') }}">
      <div class="filter-row">
        
        {{-- Search model --}}
        <div>
          <label class="f-label">Cari Laptop</label>
          <div class="f-input-wrapper">
            <i class="ti ti-search"></i>
            <input type="text" name="search" class="f-input" value="{{ $search }}" placeholder="Ketik merk / model...">
          </div>
        </div>

        {{-- Date range --}}
        <div>
          <label class="f-label">Rentang Waktu</label>
          <div class="range-inputs">
            <div class="f-input-wrapper" style="flex:1;">
              <i class="ti ti-calendar-event"></i>
              <input type="date" name="start_date" class="f-input" value="{{ $startDate }}" style="padding-left:34px;">
            </div>
            <span style="color:var(--muted); font-size:.8rem; font-weight:700;">s/d</span>
            <div class="f-input-wrapper" style="flex:1;">
              <i class="ti ti-calendar-time"></i>
              <input type="date" name="end_date" class="f-input" value="{{ $endDate }}" style="padding-left:34px;">
            </div>
          </div>
        </div>

        {{-- Status --}}
        <div>
          <label class="f-label">Status Final</label>
          <select name="status" class="f-input" style="padding-left:14px;" onchange="this.form.submit()">
            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua Riwayat</option>
            <option value="returned" {{ $status === 'returned' ? 'selected' : '' }}>Returned (Dikembalikan)</option>
            <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected (Ditolak)</option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
          </select>
        </div>

        {{-- Submit button --}}
        <div>
          <button type="submit" class="btn btn-primary" style="padding: 9.5px 16px; font-size:.8rem; display:inline-flex; align-items:center; gap:4px;">
            <i class="ti ti-filter"></i> Saring
          </button>
        </div>

      </div>
    </form>
  </section>

  {{-- 3. Timeline / Card list --}}
  <section class="history-list">
    @if($histories->isEmpty())
      
      {{-- Empty state --}}
      <div style="background:#fff; border-radius:1rem; border:1px solid #f1f5f9; padding:50px 20px; text-align:center; color:var(--muted);">
        <i class="ti ti-search-off" style="font-size:3.5rem; color:var(--muted); margin-bottom:12px; display:block; opacity:0.4;"></i>
        <h3 style="font-weight:700; color:var(--text); font-size:1.05rem; margin-bottom:4px;">Tidak ada riwayat ditemukan</h3>
        <p style="font-size:.8rem;">Belum ada data riwayat selesai yang cocok dengan kriteria saringan filter Anda.</p>
      </div>

    @else
      @foreach($histories as $b)
        <div class="hist-card">
          
          {{-- Card Top Row --}}
          <div class="hist-top">
            
            <div class="hist-thumb">
              @if($b->laptop && $b->laptop->image)
                <img src="{{ asset('storage/' . $b->laptop->image) }}" alt="Laptop thumbnail">
              @else
                <i class="ti ti-device-laptop"></i>
              @endif
            </div>

            <div class="hist-mid">
              <span class="hist-lap-name">{{ $b->laptop->brand ?? 'N/A' }} {{ $b->laptop->model ?? '' }}</span>
              <span class="hist-lap-code">Kode Unit: {{ $b->laptop->code ?? 'N/A' }}</span>
            </div>

            <div class="hist-right">
              @if($b->status === 'returned')
                <span class="badge badge-teal">Dikembalikan</span>
              @elseif($b->status === 'rejected')
                <span class="badge badge-red">Ditolak</span>
              @elseif($b->status === 'cancelled')
                <span class="badge badge-red" style="background:rgba(100,116,139,.1); color:var(--muted);">Batal</span>
              @else
                <span class="badge badge-red">{{ ucfirst($b->status) }}</span>
              @endif
            </div>

          </div>

          {{-- Card Details Grid (Only show actual return details if status is returned) --}}
          <div class="hist-details-row">
            
            {{-- Periode Pinjam --}}
            <div class="detail-item-col">
              <div class="detail-item-lbl">Tanggal Pinjam</div>
              <div class="detail-item-val">{{ $b->borrow_date->format('d M Y') }}</div>
            </div>

            {{-- Tanggal Kembali Aktual --}}
            <div class="detail-item-col">
              <div class="detail-item-lbl">Pengembalian Aktual</div>
              <div class="detail-item-val">
                @if($b->status === 'returned' && $b->actual_return_date)
                  {{ $b->actual_return_date->format('d M Y') }}
                @else
                  -
                @endif
              </div>
            </div>

            {{-- Durasi Pinjam --}}
            <div class="detail-item-col">
              <div class="detail-item-lbl">Durasi Pinjam</div>
              <div class="detail-item-val">
                @if($b->status === 'returned' && $b->actual_return_date)
                  {{ $b->borrow_date->diffInDays($b->actual_return_date) ?: 1 }} hari
                @else
                  -
                @endif
              </div>
            </div>

            {{-- Kondisi Kembali & Denda --}}
            <div class="detail-item-col">
              <div class="detail-item-lbl">Kondisi / Denda</div>
              <div class="detail-item-val">
                @if($b->status === 'returned' && $b->returns)
                  <span style="font-weight:700; color: {{ $b->returns->fine > 0 ? 'var(--red)' : 'var(--teal)' }}">
                    @if($b->returns->fine > 0)
                      Denda: Rp {{ number_format($b->returns->fine, 0, ',', '.') }}
                    @else
                      {{ str_replace('_', ' ', strtoupper($b->returns->condition_after)) }}
                    @endif
                  </span>
                @elseif($b->status === 'rejected')
                  <span style="color:var(--red); font-size:.7rem;" title="{{ $b->rejection_reason ?? 'Ditolak sistem' }}">
                    Alasan: {{ Str::limit($b->rejection_reason ?? 'Ditolak sistem', 18) }}
                  </span>
                @else
                  -
                @endif
              </div>
            </div>

          </div>

          {{-- Actions --}}
          <div class="hist-bottom-actions">
            <a href="{{ route('user.borrowings.show', $b->id) }}" class="btn btn-secondary" style="padding: 7px 14px; font-size: 0.75rem; display: inline-flex; align-items:center; gap:4px;">
              <i class="ti ti-eye"></i> Rincian Transaksi
            </a>
          </div>

        </div>
      @endforeach
    @endif
  </section>

  {{-- PAGINATION --}}
  @if($histories->hasPages())
    <div class="pagination-wrap">
      <div>
        Menampilkan {{ $histories->firstItem() }} - {{ $histories->lastItem() }} dari {{ $histories->total() }} riwayat selesai
      </div>
      <nav>
        {{-- Previous Page Link --}}
        @if ($histories->onFirstPage())
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $histories->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($histories->getUrlRange(1, $histories->lastPage()) as $page => $url)
          @if ($page == $histories->currentPage())
            <span class="active-page">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($histories->hasMorePages())
          <a href="{{ $histories->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif

</div>
@endsection
