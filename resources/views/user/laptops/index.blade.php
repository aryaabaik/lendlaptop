@extends('layouts.app')

@section('title', 'Katalog Laptop')

@section('content')
<style>
/* ─── PREMIUM CATALOG LAYOUT STYLES ───────────────────────── */
.catalog-container {
  max-width: 1200px;
  margin: 104px auto 40px;
  padding: 0 24px;
}

.catalog-layout {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 30px;
  align-items: start;
}
@media(max-width: 991px) {
  .catalog-layout {
    grid-template-columns: 1fr;
  }
}

/* 1. Catalog Header */
.catalog-header {
  margin-bottom: 24px;
}
.catalog-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--text);
  letter-spacing: -0.02em;
}

/* 2. Filter Sidebar (Sticky) */
.filter-sidebar {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 24px;
  position: sticky;
  top: 96px;
  z-index: 10;
}
.filter-title {
  font-size: .88rem;
  font-weight: 700;
  color: var(--text);
  text-transform: uppercase;
  letter-spacing: .05em;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 1.5px solid var(--teal-dim);
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-section {
  margin-bottom: 22px;
}
.filter-section:last-child {
  margin-bottom: 0;
}
.filter-section-lbl {
  display: block;
  font-size: .78rem;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 10px;
  text-transform: uppercase;
  letter-spacing: .02em;
}

/* Checkbox lists */
.checkbox-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.chk-wrapper {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: .82rem;
  color: var(--muted);
  cursor: pointer;
  user-select: none;
}
.chk-wrapper input {
  width: 16px;
  height: 16px;
  accent-color: var(--teal);
  cursor: pointer;
}
.chk-wrapper:hover {
  color: var(--text);
}

/* Toggle Switch */
.toggle-wrapper {
  display: flex;
  align-items: center;
  justify-content: space-between;
  font-size: .82rem;
  color: var(--muted);
  cursor: pointer;
}
.toggle-switch {
  position: relative;
  display: inline-block;
  width: 38px;
  height: 20px;
}
.toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}
.slider {
  position: absolute;
  cursor: pointer;
  inset: 0;
  background-color: #cbd5e1;
  transition: .3s;
  border-radius: 34px;
}
.slider:before {
  position: absolute;
  content: "";
  height: 14px;
  width: 14px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .3s;
  border-radius: 50%;
}
input:checked + .slider {
  background-color: var(--teal);
}
input:checked + .slider:before {
  transform: translateX(18px);
}

/* Custom form components */
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

/* 3. Laptop Grid */
.laptop-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
@media(max-width: 1200px) {
  .laptop-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media(max-width: 575px) {
  .laptop-grid {
    grid-template-columns: 1fr;
  }
}

.lap-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 16px;
  display: flex;
  flex-direction: column;
  transition: all .2s;
  position: relative;
}
.lap-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 24px -8px rgba(10,22,40,.08);
}

.lap-img-box {
  width: 100%;
  height: 150px;
  background: #f8fafc;
  border-radius: 10px;
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 3rem;
  color: var(--teal);
  overflow: hidden;
  margin-bottom: 12px;
  position: relative;
}
.lap-img-box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.lap-badge-pos {
  position: absolute;
  top: 10px;
  right: 10px;
  z-index: 5;
}

.lap-brand {
  font-size: .68rem;
  font-weight: 700;
  text-transform: uppercase;
  color: var(--muted);
  letter-spacing: .02em;
}
.lap-name {
  font-size: .9rem;
  font-weight: 700;
  color: var(--text);
  margin: 2px 0 6px;
}
.lap-cat-pill {
  display: inline-block;
  font-size: .68rem;
  font-weight: 700;
  color: var(--teal);
  background: var(--teal-dim);
  padding: 2px 8px;
  border-radius: 4px;
  width: fit-content;
  margin-bottom: 10px;
}

.lap-specs-truncate {
  font-size: .76rem;
  color: var(--muted);
  margin-bottom: 18px;
  line-height: 1.5;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: flex;
  align-items: center;
  gap: 4px;
}

.lap-action-row {
  margin-top: auto;
  border-top: 1px solid #f1f5f9;
  padding-top: 12px;
  display: flex;
  gap: 8px;
}
.btn-flex-1 {
  flex: 1;
  text-align: center;
  padding: 8px;
  font-size: .78rem;
  font-weight: 700;
  border-radius: 8px;
  text-decoration: none;
  cursor: pointer;
  transition: all .2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.btn-outline-custom {
  border: 1px solid #cbd5e1;
  background: #fff;
  color: var(--muted);
}
.btn-outline-custom:hover {
  background: #f8fafc;
  color: var(--text);
  border-color: #94a3b8;
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
  margin-top: 24px;
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

<div class="catalog-container">
  
  <div class="catalog-header">
    <h1 class="catalog-title">Katalog Laptop</h1>
  </div>

  <div class="catalog-layout">
    
    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{--  2. FILTER SIDEBAR (Left Sticky)                          --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <aside class="filter-sidebar">
      <div class="filter-title">
        <i class="ti ti-adjustments-horizontal"></i> Filter Pencarian
      </div>
      <form method="GET" action="{{ route('user.laptops.index') }}">
        
        {{-- Search keyword --}}
        <div class="filter-section">
          <label class="filter-section-lbl">Kata Kunci</label>
          <div class="f-input-wrapper">
            <i class="ti ti-search"></i>
            <input type="text" name="search" class="f-input" value="{{ $search }}" placeholder="Cari merk / tipe / kode...">
          </div>
        </div>

        {{-- Toggle Available Only --}}
        <div class="filter-section">
          <div class="toggle-wrapper" onclick="document.getElementById('avail_toggle').click()">
            <span style="font-weight: 700; font-size: .78rem; text-transform: uppercase; color: var(--text);">Tersedia Saja</span>
            <label class="toggle-switch">
              <input type="checkbox" name="available_only" id="avail_toggle" value="1" {{ $availableOnly ? 'checked' : '' }} onchange="this.form.submit()">
              <span class="slider"></span>
            </label>
          </div>
        </div>

        {{-- Categories list --}}
        <div class="filter-section">
          <label class="filter-section-lbl">Kategori</label>
          <div class="checkbox-group">
            @foreach($categories as $cat)
              <label class="chk-wrapper">
                <input type="checkbox" name="categories[]" value="{{ $cat->id }}" 
                       {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}
                       onchange="this.form.submit()">
                {{ $cat->name }}
              </label>
            @endforeach
          </div>
        </div>

        {{-- RAM list --}}
        <div class="filter-section">
          <label class="filter-section-lbl">Kapasitas RAM</label>
          <div class="checkbox-group">
            @foreach(['4', '8', '16', '32'] as $ramVal)
              <label class="chk-wrapper">
                <input type="checkbox" name="ram[]" value="{{ $ramVal }}" 
                       {{ in_array($ramVal, $selectedRam) ? 'checked' : '' }}
                       onchange="this.form.submit()">
                {{ $ramVal }} GB
              </label>
            @endforeach
          </div>
        </div>

        {{-- Submit trigger hidden, or submit button --}}
        <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 0.78rem; padding: 10px; margin-top: 10px;">
          <i class="ti ti-filter"></i> Terapkan Filter
        </button>
      </form>
    </aside>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{--  3. LAPTOP GRID                                            --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div>
      @if($laptops->isEmpty())
        {{-- 4. EMPTY STATE --}}
        <div style="background: #fff; border-radius: 1rem; border: 1px solid #f1f5f9; padding: 60px 20px; text-align: center; color: var(--muted);">
          <i class="ti ti-search-off" style="font-size: 4rem; color: var(--muted); margin-bottom: 16px; display: block; opacity: 0.4;"></i>
          <h3 style="font-weight: 700; color: var(--text); font-size: 1.1rem; margin-bottom: 6px;">Tidak ada laptop tersedia saat ini</h3>
          <p style="font-size: .82rem;">Silakan sesuaikan kembali kata kunci atau opsi saringan filter Anda.</p>
        </div>
      @else
        <div class="laptop-grid">
          @foreach($laptops as $lap)
            <div class="lap-card">
              
              {{-- Image box with badge status absolute --}}
              <div class="lap-img-box">
                @if($lap->image)
                  <img src="{{ asset('storage/' . $lap->image) }}" alt="Laptop image">
                @else
                  <i class="ti ti-device-laptop"></i>
                @endif

                <div class="lap-badge-pos">
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
              </div>

              {{-- Content --}}
              <div class="lap-brand">{{ $lap->brand }}</div>
              <h3 class="lap-name">{{ $lap->model }}</h3>
              
              @if($lap->category)
                <div class="lap-cat-pill">{{ $lap->category->name }}</div>
              @endif

              {{-- Truncate specs --}}
              <div class="lap-specs-truncate" title="{{ $lap->processor }} | RAM {{ $lap->ram }}GB | {{ $lap->storage }} SSD">
                <i class="ti ti-cpu" style="color:var(--teal);"></i>
                <span>{{ $lap->ram }}GB / {{ $lap->storage }} / {{ Str::limit($lap->processor, 24) }}</span>
              </div>

              {{-- Actions --}}
              <div class="lap-action-row">
                <a href="{{ route('user.laptops.show', $lap->id) }}" class="btn-flex-1 btn-outline-custom">
                  Detail
                </a>
                @if($lap->status === 'tersedia')
                  <a href="{{ route('user.laptops.show', $lap->id) }}#borrow-section" class="btn-flex-1 btn btn-primary" style="padding: 8px;">
                    Pinjam
                  </a>
                @else
                  <button type="button" class="btn-flex-1 btn btn-primary" style="opacity: 0.4; cursor: not-allowed; padding: 8px;" disabled>
                    Pinjam
                  </button>
                @endif
              </div>

            </div>
          @endforeach
        </div>

        {{-- PAGINATION --}}
        @if($laptops->hasPages())
          <div class="pagination-wrap">
            <div>
              Menampilkan {{ $laptops->firstItem() }} - {{ $laptops->lastItem() }} dari {{ $laptops->total() }} unit laptop
            </div>
            <nav>
              {{-- Previous Page Link --}}
              @if ($laptops->onFirstPage())
                <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
              @else
                <a href="{{ $laptops->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
              @endif

              {{-- Pagination Elements --}}
              @foreach ($laptops->getUrlRange(1, $laptops->lastPage()) as $page => $url)
                @if ($page == $laptops->currentPage())
                  <span class="active-page">{{ $page }}</span>
                @else
                  <a href="{{ $url }}">{{ $page }}</a>
                @endif
              @endforeach

              {{-- Next Page Link --}}
              @if ($laptops->hasMorePages())
                <a href="{{ $laptops->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
              @else
                <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
              @endif
            </nav>
          </div>
        @endif

      @endif
    </div>

  </div>

</div>
@endsection
