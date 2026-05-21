@extends('layouts.app')

@section('title', 'Katalog Laptop')

@section('content')
<style>
/* ─── CUSTOM THEMING & STYLES ───────────────────────────────── */
:root {
  --teal:      #0D9F7A;
  --teal-dark: #0b8a6a;
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

.catalog-container {
  max-width: 1200px;
  margin: 0 auto;
}

/* 1. Header & Search Row */
.catalog-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 28px;
}
.catalog-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text);
  letter-spacing: -0.02em;
}

/* Search Input styling matching theme global */
.search-form {
  display: flex;
  gap: 10px;
  max-width: 400px;
  width: 100%;
}
.input-group {
  position: relative;
  display: flex;
  align-items: center;
  flex: 1;
}
.input-group i {
  position: absolute;
  left: 16px;
  color: var(--muted);
  font-size: 1.1rem;
  pointer-events: none;
}
.input-search {
  width: 100%;
  background-color: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 16px 10px 44px; /* px-4 py-2.5 + ikon left space */
  font-family: 'Inter', sans-serif;
  font-size: 0.88rem;
  color: var(--text);
  outline: none;
  transition: all 0.2s ease;
}
.input-search:focus {
  border-color: var(--teal);
  background-color: #fff;
  box-shadow: 0 0 0 3px rgba(13,159,122,.12);
}

.btn-search {
  background-color: var(--teal);
  color: #fff;
  font-weight: 600;
  border-radius: 0.5rem;
  padding: 10px 20px;
  font-size: 0.88rem;
  border: none;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-search:hover {
  background-color: var(--teal-dark);
}

/* 2. Grid Layout (3 kolom -> 2 -> 1 responsive) */
.laptop-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}
@media (max-width: 991px) {
  .laptop-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (max-width: 640px) {
  .laptop-grid {
    grid-template-columns: 1fr;
  }
}

/* Card Styling */
.lap-card {
  background-color: #fff; /* bg-white */
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 24px;
  display: flex;
  flex-direction: column;
  position: relative;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.lap-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(10,22,40,.06);
}

/* Badge Status in top right corner */
.badge-pos {
  position: absolute;
  top: 16px;
  right: 16px;
  z-index: 5;
}
.badge {
  display: inline-flex;
  align-items: center;
  padding: 4px 10px;
  border-radius: 9999px;
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: .03em;
}
.badge-teal {
  background-color: var(--teal-dim);
  color: var(--teal);
}
.badge-blue {
  background-color: rgba(59,130,246,.12);
  color: var(--blue);
}
.badge-amber {
  background-color: rgba(245,158,11,.12);
  color: var(--amber);
}
.badge-red {
  background-color: rgba(239,68,68,.12);
  color: var(--red);
}

/* Large Centered Laptop Icon */
.lap-icon-box {
  width: 100px;
  height: 100px;
  background-color: var(--teal-dim);
  color: var(--teal);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 16px auto 20px;
  font-size: 3rem;
  transition: transform 0.3s ease;
}
.lap-card:hover .lap-icon-box {
  transform: scale(1.05);
}

/* Laptop Name */
.lap-name-box {
  text-align: center;
  margin-bottom: 24px;
}
.lap-brand {
  font-size: 0.72rem;
  font-weight: 700;
  text-transform: uppercase;
  color: var(--muted);
  letter-spacing: 0.05em;
  margin-bottom: 4px;
}
.lap-model {
  font-size: 1rem;
  font-weight: 700; /* bold */
  color: var(--text);
}

/* Pinjam Button (full-width teal) */
.btn-pinjam-full {
  width: 100%;
  background-color: var(--teal); /* bg-[#0D9F7A] */
  color: #fff;
  font-weight: 600;
  font-size: 0.88rem;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px; /* px-5 py-2.5 equivalent */
  border: none;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s ease;
  margin-top: auto;
}
.btn-pinjam-full:hover {
  background-color: var(--teal-dark); /* hover:bg-[#0b8a6a] */
}
.btn-pinjam-disabled {
  background-color: #cbd5e1 !important;
  color: #94a3b8 !important;
  cursor: not-allowed !important;
  box-shadow: none !important;
  transform: none !important;
}

/* 3. Empty State */
.empty-state {
  background-color: #fff;
  border-radius: 0.75rem;
  border: 1px solid #f3f4f6;
  padding: 64px 24px;
  text-align: center;
  color: var(--muted);
  max-width: 600px;
  margin: 40px auto;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
}
.empty-state i {
  font-size: 3.5rem;
  color: var(--muted);
  opacity: 0.4;
  display: block;
  margin-bottom: 16px;
}
.empty-state h3 {
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 6px;
}
.empty-state p {
  font-size: 0.88rem;
  margin-bottom: 20px;
}

/* Pagination bar wrapper */
.pagi-wrap {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 0;
  margin-top: 32px;
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
  min-width: 34px;
  height: 34px;
  padding: 0 8px;
  border-radius: 8px;
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

<div class="catalog-container">
  
  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  1. HEADER & SEARCH                                        --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div class="catalog-header-row">
    <h1 class="catalog-title">Katalog Laptop</h1>
    
    <form method="GET" action="{{ route('user.laptops.index') }}" class="search-form">
      <div class="input-group">
        <i class="ti ti-search"></i>
        <input type="text" name="search" class="input-search" value="{{ $search }}" placeholder="Cari brand atau model...">
      </div>
      <button type="submit" class="btn-search">Cari</button>
    </form>
  </div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  2. GRID / 3. EMPTY STATE                                  --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  @if($laptops->isEmpty())
    <div class="empty-state">
      <i class="ti ti-device-laptop-off"></i>
      <h3>Tidak ada laptop tersedia saat ini</h3>
      <p>Mohon maaf, semua unit laptop sedang dipinjam atau tidak ditemukan dengan filter pencarian ini.</p>
      @if($search)
        <a href="{{ route('user.laptops.index') }}" class="welcome-action" style="padding: 8px 16px;">
          Lihat Semua Laptop
        </a>
      @endif
    </div>
  @else
    <div class="laptop-grid">
      @foreach($laptops as $lap)
        <div class="lap-card">
          
          {{-- Badge status pojok kanan atas --}}
          <div class="badge-pos">
            @if($lap->status === 'tersedia')
              <span class="badge badge-teal">Tersedia</span>
            @elseif($lap->status === 'dipinjam')
              <span class="badge badge-blue">Dipinjam</span>
            @elseif($lap->status === 'maintenance')
              <span class="badge badge-amber">Maintenance</span>
            @else
              <span class="badge badge-red">Rusak</span>
            @endif
          </div>

          {{-- Ikon laptop besar (teal, centered) --}}
          <div class="lap-icon-box">
            <i class="ti ti-device-laptop"></i>
          </div>

          {{-- Nama: brand + model (bold) --}}
          <div class="lap-name-box">
            <div class="lap-brand">{{ $lap->brand }}</div>
            <div class="lap-model">{{ $lap->model }}</div>
            <div style="font-size: 0.72rem; color: var(--muted); font-family: monospace; margin-top: 4px;">
              {{ $lap->code }}
            </div>
          </div>

          {{-- Tombol "Pinjam Sekarang" full-width teal --}}
          @if($lap->status === 'tersedia')
            <a href="{{ route('user.laptops.show', $lap->id) }}" class="btn-pinjam-full">
              Pinjam Sekarang <i class="ti ti-arrow-right"></i>
            </a>
          @else
            <button type="button" class="btn-pinjam-full btn-pinjam-disabled" disabled>
              <i class="ti ti-lock"></i> Sedang Dipinjam
            </button>
          @endif

        </div>
      @endforeach
    </div>

    {{-- Pagination bar --}}
    @if($laptops->hasPages())
      <div class="pagi-wrap">
        <span>
          Menampilkan {{ $laptops->firstItem() }} – {{ $laptops->lastItem() }} dari {{ $laptops->total() }} unit
        </span>
        <nav class="pagi-links">
          {{-- Prev --}}
          @if($laptops->onFirstPage())
            <span class="disabled-pg"><i class="ti ti-chevron-left"></i></span>
          @else
            <a href="{{ $laptops->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
          @endif

          {{-- Numbers --}}
          @foreach($laptops->getUrlRange(1, $laptops->lastPage()) as $page => $url)
            @if($page == $laptops->currentPage())
              <span class="active-pg">{{ $page }}</span>
            @else
              <a href="{{ $url }}">{{ $page }}</a>
            @endif
          @endforeach

          {{-- Next --}}
          @if($laptops->hasMorePages())
            <a href="{{ $laptops->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
          @else
            <span class="disabled-pg"><i class="ti ti-chevron-right"></i></span>
          @endif
        </nav>
      </div>
    @endif
  @endif

</div>
@endsection
