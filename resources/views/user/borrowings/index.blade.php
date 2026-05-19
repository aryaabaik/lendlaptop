@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<style>
/* ─── PREMIUM USER BORROWINGS STYLES ──────────────────────── */
.borrowings-container {
  max-width: 800px;
  margin: 104px auto 40px;
  padding: 0 24px;
}

/* Header */
.b-header {
  margin-bottom: 24px;
}
.b-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text);
  letter-spacing: -0.02em;
}

/* Tab controls */
.tab-container {
  display: flex;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 4px;
  margin-bottom: 24px;
}
.tab-btn {
  flex: 1;
  text-align: center;
  padding: 10px;
  font-size: .82rem;
  font-weight: 600;
  color: var(--muted);
  text-decoration: none;
  border-radius: 8px;
  transition: all .2s;
}
.tab-btn:hover {
  color: var(--text);
}
.tab-btn.active {
  background: var(--teal);
  color: #fff;
  box-shadow: 0 4px 10px rgba(13,159,122,.2);
}

/* Card List */
.cards-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 24px;
}
.b-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 20px;
  display: flex;
  flex-direction: column;
  transition: all .2s;
}
.b-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(10,22,40,.04);
}

.b-card-top {
  display: grid;
  grid-template-columns: auto 1fr auto;
  gap: 16px;
  align-items: center;
}
@media(max-width: 575px) {
  .b-card-top {
    grid-template-columns: 1fr;
    text-align: center;
    justify-items: center;
    gap: 12px;
  }
}

.b-thumb {
  width: 64px;
  height: 64px;
  border-radius: 10px;
  border: 1px solid var(--border);
  background: #f8fafc;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--teal);
  font-size: 1.5rem;
  flex-shrink: 0;
}
.b-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 9px;
}

.b-mid {
  display: flex;
  flex-direction: column;
}
.b-lap-name {
  font-weight: 700;
  font-size: .95rem;
  color: var(--text);
}
.b-lap-code {
  font-family: monospace;
  font-size: .75rem;
  color: var(--muted);
  margin-top: 2px;
}
.b-purpose {
  font-size: .78rem;
  color: var(--muted);
  margin-top: 6px;
  display: -webkit-box;
  -webkit-line-clamp: 1;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.b-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 6px;
}
@media(max-width: 575px) {
  .b-right {
    align-items: center;
  }
}
.b-date-lbl {
  font-size: .7rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
}

/* Progress bar block */
.b-progress-block {
  margin-top: 16px;
  padding-top: 14px;
  border-top: 1px solid #f1f5f9;
}
.progress-meta {
  display: flex;
  justify-content: space-between;
  font-size: .7rem;
  font-weight: 600;
  color: var(--muted);
  margin-bottom: 6px;
}
.progress-bar-bg {
  width: 100%;
  height: 5px;
  background: #e2e8f0;
  border-radius: 3px;
  overflow: hidden;
}
.progress-bar-fill {
  height: 100%;
  border-radius: 3px;
}

/* Card Actions */
.b-actions {
  margin-top: 14px;
  padding-top: 12px;
  border-top: 1px solid #f1f5f9;
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

<div class="borrowings-container">
  
  {{-- Header --}}
  <div class="b-header">
    <h1 class="b-title">Peminjaman Saya</h1>
  </div>

  {{-- Tab Navigation --}}
  <nav class="tab-container">
    <a href="{{ route('user.borrowings.index', ['tab' => 'active']) }}" 
       class="tab-btn {{ $tab === 'active' ? 'active' : '' }}">
      Aktif
    </a>
    <a href="{{ route('user.borrowings.index', ['tab' => 'pending']) }}" 
       class="tab-btn {{ $tab === 'pending' ? 'active' : '' }}">
      Menunggu
    </a>
    <a href="{{ route('user.borrowings.index', ['tab' => 'all']) }}" 
       class="tab-btn {{ $tab === 'all' ? 'active' : '' }}">
      Semua
    </a>
  </nav>

  {{-- Card List --}}
  <section class="cards-list">
    @if($borrowings->isEmpty())
      
      {{-- Empty State Card --}}
      <div style="background: #fff; border-radius: 1rem; border: 1px solid #f1f5f9; padding: 60px 20px; text-align: center; color: var(--muted);">
        <i class="ti ti-folders" style="font-size: 3.5rem; color: var(--muted); margin-bottom: 16px; display: block; opacity: 0.4;"></i>
        <h3 style="font-weight: 700; color: var(--text); font-size: 1.05rem; margin-bottom: 6px;">
          @if($tab === 'active')
            Tidak ada peminjaman aktif saat ini
          @elseif($tab === 'pending')
            Tidak ada pengajuan menunggu persetujuan
          @else
            Anda belum pernah mengajukan peminjaman
          @endif
        </h3>
        <p style="font-size: .8rem; margin-bottom: 16px;">
          Silakan ajukan peminjaman unit laptop baru pada katalog unit kami yang tersedia.
        </p>
        <a href="{{ route('user.laptops.index') }}" class="btn btn-primary" style="display: inline-flex; align-items:center; gap:6px; padding: 8px 18px; font-size: 0.8rem;">
          <i class="ti ti-device-laptop"></i> Jelajahi Katalog Laptop
        </a>
      </div>

    @else
      @foreach($borrowings as $b)
        @php
          // Hitung progress bar jika berstatus approved atau borrowed
          $showProgress = in_array($b->status, ['approved', 'borrowed', 'late']);
          $totalDays = 1;
          $elapsedDays = 0;
          $pct = 0;
          $barColor = 'var(--teal)';
          $remainingText = '';

          if ($showProgress) {
              $totalDays = $b->borrow_date->diffInDays($b->return_date) ?: 1;
              $elapsedDays = $b->borrow_date->diffInDays(now()) ?: 0;
              $pct = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));
              $barColor = $pct > 80 ? 'var(--red)' : ($pct > 50 ? 'var(--amber)' : 'var(--teal)');
              
              $remainingDays = now()->diffInDays($b->return_date, false);
              if ($remainingDays < 0) {
                  $remainingText = 'Terlambat ' . abs($remainingDays) . ' hari';
              } else {
                  $remainingText = $remainingDays . ' hari tersisa';
              }
          }
        @endphp

        <div class="b-card">
          
          {{-- Card Top Row --}}
          <div class="b-card-top">
            
            {{-- Thumb photo --}}
            <div class="b-thumb">
              @if($b->laptop && $b->laptop->image)
                <img src="{{ asset('storage/' . $b->laptop->image) }}" alt="Laptop image">
              @else
                <i class="ti ti-device-laptop"></i>
              @endif
            </div>

            {{-- Middle Column --}}
            <div class="b-mid">
              <span class="b-lap-name">{{ $b->laptop->brand ?? 'N/A' }} {{ $b->laptop->model ?? '' }}</span>
              <span class="b-lap-code">Kode Unit: {{ $b->laptop->code ?? 'N/A' }}</span>
              <p class="b-purpose" title="{{ $b->purpose }}">Keperluan: {{ $b->purpose }}</p>
            </div>

            {{-- Right Column --}}
            <div class="b-right">
              @if($b->status === 'pending')
                <span class="badge badge-amber">Pending</span>
              @elseif($b->status === 'approved')
                <span class="badge badge-teal">Disetujui</span>
              @elseif($b->status === 'borrowed')
                <span class="badge badge-blue">Sedang Dipinjam</span>
              @elseif($b->status === 'returned')
                <span class="badge badge-teal">Dikembalikan</span>
              @elseif($b->status === 'rejected')
                <span class="badge badge-red">Ditolak</span>
              @elseif($b->status === 'cancelled')
                <span class="badge badge-red">Dibatalkan</span>
              @else
                <span class="badge badge-red">{{ ucfirst($b->status) }}</span>
              @endif
              
              <div style="text-align: right; margin-top:4px;">
                <div class="b-date-lbl">Batas Pengembalian</div>
                <div style="font-size: 0.78rem; font-weight: 700; color: var(--text);">
                  {{ $b->return_date->format('d M Y') }}
                </div>
              </div>
            </div>

          </div>

          {{-- Progress Bar (Only for approved/borrowed) --}}
          @if($showProgress)
            <div class="b-progress-block">
              <div class="progress-meta">
                <span>{{ $remainingText }}</span>
                <span>{{ $pct }}% Masa Pinjam</span>
              </div>
              <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: {{ $pct }}%; background: {{ $barColor }};"></div>
              </div>
            </div>
          @endif

          {{-- Card Bottom Actions --}}
          <div class="b-actions">
            
            <a href="{{ route('user.borrowings.show', $b->id) }}" class="btn btn-secondary" style="padding: 7px 14px; font-size: 0.75rem; display: inline-flex; align-items:center; gap:4px;">
              <i class="ti ti-eye"></i> Detail
            </a>

            @if($b->status === 'pending')
              <form method="POST" action="{{ route('user.borrowings.destroy', $b->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan peminjaman ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary" style="background:#ef4444; border-color:#ef4444; padding: 7px 14px; font-size: 0.75rem; display: inline-flex; align-items:center; gap:4px;">
                  <i class="ti ti-ban"></i> Batalkan
                </button>
              </form>
            @endif

          </div>

        </div>
      @endforeach
    @endif
  </section>

  {{-- PAGINATION --}}
  @if($borrowings->hasPages())
    <div class="pagination-wrap">
      <div>
        Menampilkan {{ $borrowings->firstItem() }} - {{ $borrowings->lastItem() }} dari {{ $borrowings->total() }} riwayat
      </div>
      <nav>
        {{-- Previous Page Link --}}
        @if ($borrowings->onFirstPage())
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $borrowings->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($borrowings->getUrlRange(1, $borrowings->lastPage()) as $page => $url)
          @if ($page == $borrowings->currentPage())
            <span class="active-page">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($borrowings->hasMorePages())
          <a href="{{ $borrowings->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif

</div>
@endsection
