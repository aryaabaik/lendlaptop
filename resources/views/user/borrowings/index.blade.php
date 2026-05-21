@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<style>
/* ─── THEMING & BORROWINGS LIST STYLES ─────────────────────── */
:root {
  --teal:      #0D9F7A;
  --teal-dark: #0b8a6a;
  --teal-dim:  rgba(13,159,122,.10);
  --navy:      #0A1628;
  --red:       #EF4444;
  --red-dim:   rgba(239,68,68,.10);
  --amber:     #F59E0B;
  --blue:      #3B82F6;
  --text:      #1e293b;
  --muted:     #64748b;
  --border:    #e2e8f0;
  --bg:        #f8fafc;
}

.borrowings-container {
  max-width: 800px;
  margin: 0 auto;
}

/* 1. Header */
.b-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--navy);
  margin-bottom: 24px;
}

/* 2. Tabs (Pill Tabs, aktif bg-teal text-white) */
.tab-row {
  display: flex;
  gap: 8px;
  margin-bottom: 28px;
  border-bottom: 1px solid #f1f5f9;
  padding-bottom: 12px;
}
.tab-pill {
  padding: 8px 18px;
  font-size: 0.88rem;
  font-weight: 600;
  color: var(--muted);
  text-decoration: none;
  border-radius: 9999px; /* pill tabs */
  transition: all 0.2s ease;
}
.tab-pill:hover {
  color: var(--text);
  background-color: #f1f5f9;
}
.tab-pill.active {
  background-color: var(--teal);
  color: #fff !important;
}

/* 3. Card List */
.cards-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
  margin-bottom: 28px;
}

/* Card: bg-white, rounded-xl, border border-gray-100 */
.b-card {
  background-color: #fff;
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border border-gray-100 */
  box-shadow: 0 1px 3px rgba(0,0,0,.01);
  padding: 20px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.b-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(10,22,40,.04);
}

.b-card-main {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 16px;
}

/* Kiri: ikon laptop teal (48x48 bg-teal-50 rounded-lg) */
.b-icon-box {
  width: 48px;
  height: 48px;
  background-color: var(--teal-dim); /* bg-teal-50 equivalent */
  color: var(--teal);
  border-radius: 0.5rem; /* rounded-lg */
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  flex-shrink: 0;
}

/* Tengah: brand+model (bold) + keperluan (truncate) */
.b-info-box {
  flex: 1;
  min-width: 0; /* allows text truncation */
}
.b-laptop-name {
  font-weight: 700; /* bold */
  font-size: 0.95rem;
  color: var(--text);
  display: block;
}
.b-purpose-text {
  font-size: 0.8rem;
  color: var(--muted);
  margin-top: 4px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis; /* truncate */
}

/* Kanan */
.b-side-box {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  justify-content: space-between;
  height: 48px;
  flex-shrink: 0;
}

/* Badge status */
.badge {
  display: inline-flex;
  align-items: center;
  padding: 4px 10px;
  border-radius: 9999px;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .03em;
}
.badge-teal   { background-color: var(--teal-dim); color: var(--teal); }
.badge-blue   { background-color: rgba(59,130,246,.12); color: var(--blue); }
.badge-amber  { background-color: rgba(245,158,11,.12); color: var(--amber); }
.badge-red    { background-color: rgba(239,68,68,.12); color: var(--red); }

/* Kanan bawah: "Kembali: [tgl]" teks abu */
.b-return-date {
  font-size: 0.75rem;
  color: var(--muted); /* teks abu */
  font-weight: 500;
}

/* Bawah: progress bar sisa hari (jika status borrowed) */
.b-progress-block {
  margin-top: 16px;
  padding-top: 14px;
  border-top: 1px solid #f9fafb;
}
.progress-meta {
  display: flex;
  justify-content: space-between;
  font-size: 0.72rem;
  font-weight: 600;
  color: var(--muted);
  margin-bottom: 6px;
}
.progress-bar-bg {
  width: 100%;
  height: 5px;
  background-color: #f1f5f9;
  border-radius: 3px;
  overflow: hidden;
}
.progress-bar-fill {
  height: 100%;
  border-radius: 3px;
  transition: width .5s ease;
}

/* Card Actions */
.b-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 14px;
  gap: 10px;
}

/* Tombol "Batalkan" outline red kecil jika masih pending */
.btn-cancel-outline {
  background-color: #fff;
  border: 1px solid var(--red);
  color: var(--red);
  font-weight: 600;
  font-size: 0.75rem; /* kecil */
  padding: 6px 14px;
  border-radius: 0.375rem; /* rounded-md */
  cursor: pointer;
  text-decoration: none;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}
.btn-cancel-outline:hover {
  background-color: var(--red-dim);
}

.btn-detail {
  background-color: #fff;
  border: 1px solid var(--border);
  color: var(--text);
  font-weight: 600;
  font-size: 0.75rem;
  padding: 6px 14px;
  border-radius: 0.375rem;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: background 0.2s;
}
.btn-detail:hover {
  background-color: #f9fafb;
}

/* 4. Empty State */
.empty-state {
  background-color: #fff;
  border-radius: 0.75rem;
  border: 1px solid #f3f4f6;
  padding: 56px 24px;
  text-align: center;
  color: var(--muted);
  box-shadow: 0 1px 3px rgba(0,0,0,.01);
}
.empty-state i {
  font-size: 3.5rem;
  color: var(--muted);
  opacity: 0.35;
  display: block;
  margin-bottom: 16px;
}
.empty-state h3 {
  font-size: 1.05rem;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 6px;
}
.empty-state p {
  font-size: 0.82rem;
  margin-bottom: 20px;
}

/* Pagination bar wrapper */
.pagi-wrap {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 0;
  margin-top: 24px;
  font-size: 0.84rem;
  color: var(--muted);
}
.pagi-links {
  display: flex;
  gap: 6px;
}
.pagi-links a, .pagi-links span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 32px;
  height: 32px;
  padding: 0 8px;
  border-radius: 6px;
  border: 1px solid var(--border);
  background-color: #fff;
  text-decoration: none;
  color: var(--text);
  font-weight: 600;
  transition: all 0.2s;
}
.pagi-links a:hover {
  background-color: var(--teal-dim);
  color: var(--teal);
  border-color: var(--teal);
}
.pagi-links .active-pg {
  background-color: var(--teal);
  color: #fff;
  border-color: var(--teal);
}
.pagi-links .disabled-pg {
  opacity: 0.4;
  pointer-events: none;
}
</style>

<div class="borrowings-container">
  
  {{-- 1. HEADER --}}
  <h1 class="b-title">Peminjaman Saya</h1>

  @if(session('success'))
    <div style="background-color:rgba(13,159,122,0.06); border:1px solid rgba(13,159,122,0.15); border-radius:0.5rem; padding:12px 16px; color:var(--teal); font-size:0.84rem; margin-bottom:20px;">
      {{ session('success') }}
    </div>
  @endif

  @if(session('error'))
    <div style="background-color:rgba(239,68,68,0.06); border:1px solid rgba(239,68,68,0.15); border-radius:0.5rem; padding:12px 16px; color:var(--red); font-size:0.84rem; margin-bottom:20px;">
      {{ session('error') }}
    </div>
  @endif

  {{-- 2. TABS (Pill Tabs, aktif bg-teal text-white) --}}
  <nav class="tab-row">
    <a href="{{ route('user.borrowings.index', ['tab' => 'active']) }}" 
       class="tab-pill {{ $tab === 'active' ? 'active' : '' }}">
      Aktif
    </a>
    <a href="{{ route('user.borrowings.index', ['tab' => 'pending']) }}" 
       class="tab-pill {{ $tab === 'pending' ? 'active' : '' }}">
      Menunggu
    </a>
    <a href="{{ route('user.borrowings.index', ['tab' => 'all']) }}" 
       class="tab-pill {{ $tab === 'all' ? 'active' : '' }}">
      Semua
    </a>
  </nav>

  {{-- 3. CARD LIST / 4. EMPTY STATE --}}
  <section class="cards-list">
    @if($borrowings->isEmpty())
      
      {{-- Empty state per tab --}}
      <div class="empty-state">
        <i class="ti ti-folder-off"></i>
        @if($tab === 'active')
          <h3>Tidak ada peminjaman aktif</h3>
          <p>Anda sedang tidak memegang atau meminjam unit laptop apa pun.</p>
        @elseif($tab === 'pending')
          <h3>Tidak ada pengajuan menunggu</h3>
          <p>Seluruh pengajuan peminjaman Anda sudah dikonfirmasi atau dibatalkan.</p>
        @else
          <h3>Belum ada riwayat peminjaman</h3>
          <p>Anda belum pernah melakukan pengajuan peminjaman laptop.</p>
        @endif
        <a href="{{ route('user.laptops.index') }}" class="tab-pill active">Jelajahi Katalog</a>
      </div>

    @else
      @foreach($borrowings as $b)
        @php
          $isBorrowed = ($b->status === 'borrowed' || $b->status === 'late');
          
          // Progress bar variables
          $totalDays = 1;
          $elapsedDays = 0;
          $pct = 0;
          $barColor = 'var(--teal)';
          $remainingText = '';

          if ($isBorrowed) {
              $totalDays = $b->borrow_date->diffInDays($b->return_date) ?: 1;
              $elapsedDays = $b->borrow_date->diffInDays(now()) ?: 0;
              $pct = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));
              
              $daysLeft = now()->diffInDays($b->return_date, false);
              if ($daysLeft < 0) {
                  $barColor = 'var(--red)';
                  $remainingText = 'Terlambat ' . abs($daysLeft) . ' hari!';
              } elseif ($daysLeft < 2) {
                  $barColor = 'var(--amber)';
                  $remainingText = 'Sisa ' . $daysLeft . ' hari lagi';
              } else {
                  $barColor = 'var(--teal)';
                  $remainingText = 'Sisa ' . $daysLeft . ' hari';
              }
          }
        @endphp
        <div class="b-card">
          
          <div class="b-card-main">
            
            {{-- Kiri: ikon laptop teal (48x48 bg-teal-50 rounded-lg) --}}
            <div class="b-icon-box">
              <i class="ti ti-device-laptop"></i>
            </div>

            {{-- Tengah: brand+model (bold) + keperluan (truncate) --}}
            <div class="b-info-box">
              <span class="b-laptop-name">{{ $b->laptop->brand ?? 'N/A' }} {{ $b->laptop->model ?? '' }}</span>
              <div class="b-purpose-text" title="{{ $b->purpose }}">
                Keperluan: {{ $b->purpose }}
              </div>
            </div>

            {{-- Kanan --}}
            <div class="b-side-box">
              {{-- Kanan atas: badge status --}}
              <div>
                @if($b->status === 'pending')
                  <span class="badge badge-amber">Menunggu</span>
                @elseif($b->status === 'approved')
                  <span class="badge badge-teal">Disetujui</span>
                @elseif($b->status === 'borrowed')
                  <span class="badge badge-blue">Dipinjam</span>
                @elseif($b->status === 'returned')
                  <span class="badge badge-teal">Kembali</span>
                @elseif($b->status === 'rejected')
                  <span class="badge badge-red">Ditolak</span>
                @elseif($b->status === 'cancelled')
                  <span class="badge badge-red">Batal</span>
                @else
                  <span class="badge badge-teal">{{ ucfirst($b->status) }}</span>
                @endif
              </div>

              {{-- Kanan bawah: "Kembali: [tgl]" teks abu --}}
              <div class="b-return-date">
                Kembali: {{ $b->return_date->format('d M Y') }}
              </div>
            </div>

          </div>

          {{-- Bawah: progress bar sisa hari (jika status borrowed) --}}
          @if($isBorrowed)
            <div class="b-progress-block">
              <div class="progress-meta">
                <span style="font-weight: 700; color: {{ $barColor }};">{{ $remainingText }}</span>
                <span>{{ $pct }}% Durasi</span>
              </div>
              <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: {{ $pct }}%; background-color: {{ $barColor }};"></div>
              </div>
            </div>
          @endif

          {{-- Actions --}}
          <div class="b-actions">
            <a href="{{ route('user.borrowings.show', $b->id) }}" class="btn-detail">
              <i class="ti ti-info-circle"></i> Detail
            </a>

            {{-- Tombol "Batalkan" outline red kecil jika masih pending --}}
            @if($b->status === 'pending')
              <form method="POST" action="{{ route('user.borrowings.destroy', $b->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-cancel-outline">
                  <i class="ti ti-circle-x"></i> Batalkan
                </button>
              </form>
            @endif
          </div>

        </div>
      @endforeach
    @endif
  </section>

  {{-- Pagination --}}
  @if($borrowings->hasPages())
    <div class="pagi-wrap">
      <span>
        Menampilkan {{ $borrowings->firstItem() }} – {{ $borrowings->lastItem() }} dari {{ $borrowings->total() }} riwayat
      </span>
      <nav class="pagi-links">
        {{-- Prev --}}
        @if($borrowings->onFirstPage())
          <span class="disabled-pg"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $borrowings->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        {{-- Numbers --}}
        @foreach($borrowings->getUrlRange(1, $borrowings->lastPage()) as $page => $url)
          @if($page == $borrowings->currentPage())
            <span class="active-pg">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next --}}
        @if($borrowings->hasMorePages())
          <a href="{{ $borrowings->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span class="disabled-pg"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif

</div>
@endsection
