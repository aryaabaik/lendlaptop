@extends('layouts.admin')

@section('title', 'Maintenance Laptop')
@section('page_title', 'Maintenance Laptop')
@section('breadcrumb')
  <span>Maintenance</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM MAINTENANCE STYLE ───────────────────────────── */
.maint-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
}
.maint-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text);
}

/* Status Tabs (Pill Tabs) */
.pill-tabs-container {
  display: flex;
  gap: 8px;
  overflow-x: auto;
  padding-bottom: 8px;
  margin-bottom: 24px;
  border-bottom: 1px solid #e2e8f0;
}
.pill-tab {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 8px 16px;
  background: #f1f5f9;
  color: #475569;
  border-radius: 9999px;
  text-decoration: none;
  font-size: .82rem;
  font-weight: 600;
  white-space: nowrap;
  transition: all .2s ease;
}
.pill-tab:hover {
  background: #e2e8f0;
  color: var(--text);
}
.pill-tab.active {
  background: var(--teal);
  color: #fff;
  box-shadow: 0 4px 10px rgba(13,159,122,.2);
}
.tab-badge {
  background: rgba(10,22,40,.08);
  color: #475569;
  font-size: .7rem;
  font-weight: 700;
  padding: 2px 6px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.pill-tab.active .tab-badge {
  background: rgba(255,255,255,.2);
  color: #fff;
}

/* Filter Card */
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

/* Kanban Cards Grid */
.maint-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}
.maint-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 20px;
  transition: all .2s;
  display: flex;
  flex-direction: column;
  position: relative;
}
.maint-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 20px -8px rgba(10,22,40,.06);
  border-color: var(--teal-border);
}

.maint-laptop-box {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
}
.maint-thumb {
  width: 52px;
  height: 52px;
  border-radius: 10px;
  border: 1px solid var(--border);
  background: #f8fafc;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--teal);
  font-size: 1.3rem;
  flex-shrink: 0;
}
.maint-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 9px;
}

.maint-code {
  font-family: monospace;
  font-weight: 700;
  font-size: .8rem;
  color: var(--text);
}
.maint-name {
  font-size: .88rem;
  font-weight: 700;
  color: var(--text);
  margin-top: 1px;
}
.maint-brand {
  font-size: .72rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
}

.maint-issue {
  font-size: .8rem;
  color: var(--muted);
  line-height: 1.5;
  margin-bottom: 16px;
  height: 36px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.maint-footer {
  margin-top: auto;
  padding-top: 14px;
  border-top: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.maint-cost {
  font-size: .88rem;
  font-weight: 700;
  color: var(--text);
}
.maint-cost span {
  display: block;
  font-size: .68rem;
  color: var(--muted);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .02em;
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
  max-width: 480px;
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

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  1. HEADER                                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="maint-header">
  <h1 class="maint-title">Maintenance Laptop</h1>
  <button class="btn btn-primary" onclick="openCreateModal()">
    <i class="ti ti-plus"></i> Tambah Maintenance
  </button>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  TAB STATUS                                                --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="pill-tabs-container">
  @php
    $currentStatus = request('status', 'all');
  @endphp
  
  {{-- Semua --}}
  <a href="{{ route('admin.maintenances.index', array_merge(request()->except('status'), ['status' => 'all'])) }}" 
     class="pill-tab {{ $currentStatus === 'all' ? 'active' : '' }}">
    Semua <span class="tab-badge">{{ $counts['all'] }}</span>
  </a>

  {{-- Pending --}}
  <a href="{{ route('admin.maintenances.index', array_merge(request()->except('status'), ['status' => 'pending'])) }}" 
     class="pill-tab {{ $currentStatus === 'pending' ? 'active' : '' }}">
    Pending <span class="tab-badge" style="{{ $counts['pending'] > 0 ? 'background:#f59e0b;color:#fff;' : '' }}">{{ $counts['pending'] }}</span>
  </a>

  {{-- In Progress --}}
  <a href="{{ route('admin.maintenances.index', array_merge(request()->except('status'), ['status' => 'in_progress'])) }}" 
     class="pill-tab {{ $currentStatus === 'in_progress' ? 'active' : '' }}">
    In Progress <span class="tab-badge" style="{{ $counts['in_progress'] > 0 ? 'background:#3b82f6;color:#fff;' : '' }}">{{ $counts['in_progress'] }}</span>
  </a>

  {{-- Completed --}}
  <a href="{{ route('admin.maintenances.index', array_merge(request()->except('status'), ['status' => 'completed'])) }}" 
     class="pill-tab {{ $currentStatus === 'completed' ? 'active' : '' }}">
    Completed <span class="tab-badge">{{ $counts['completed'] }}</span>
  </a>
</div>

{{-- Filter Card --}}
<section class="filter-card">
  <form method="GET" action="{{ route('admin.maintenances.index') }}">
    <input type="hidden" name="status" value="{{ request('status', 'all') }}">

    <div class="filter-grid">
      
      {{-- Search --}}
      <div>
        <label class="f-label">Cari Laptop</label>
        <div class="f-input-wrapper">
          <i class="ti ti-search"></i>
          <input type="text" name="search" class="f-input" value="{{ request('search') }}" placeholder="Cari kode unit / tipe laptop...">
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
{{--  2. MAINTENANCE CARDS GRID                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="maint-grid">
  @if($maintenances->isEmpty())
    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background:#fff; border-radius:1rem; border:1px solid #f1f5f9;">
      <i class="ti ti-tool" style="font-size: 3rem; color:var(--muted); margin-bottom:12px; display:block; opacity:0.5;"></i>
      Tidak ada agenda maintenance ditemukan.
    </div>
  @else
    @foreach($maintenances as $m)
      <div class="maint-card">
        
        {{-- Laptop Info --}}
        <div class="maint-laptop-box">
          <div class="maint-thumb">
            @if($m->laptop && $m->laptop->image)
              <img src="{{ asset('storage/' . $m->laptop->image) }}" alt="Laptop thumbnail">
            @else
              <i class="ti ti-device-laptop"></i>
            @endif
          </div>
          <div>
            <div class="maint-brand">{{ $m->laptop->brand ?? 'N/A' }}</div>
            <div class="maint-name">{{ $m->laptop->model ?? 'N/A' }}</div>
            <div class="maint-code">{{ $m->laptop->code ?? 'N/A' }}</div>
          </div>
        </div>

        {{-- Issue Description --}}
        <p class="maint-issue" title="{{ $m->issue }}">
          {{ $m->issue }}
        </p>

        {{-- Footer --}}
        <div class="maint-footer">
          <div class="maint-cost">
            <span>Biaya Perbaikan</span>
            @if($m->repair_cost > 0)
              Rp {{ number_format($m->repair_cost, 0, ',', '.') }}
            @else
              <span style="color:var(--muted); font-size: 0.8rem; font-weight:700;">Rp 0 (Estimasi)</span>
            @endif
          </div>

          <div style="display:flex; align-items:center; gap:8px;">
            {{-- Status Badge --}}
            @if($m->status === 'pending')
              <span class="badge badge-amber">Pending</span>
            @elseif($m->status === 'in_progress')
              <span class="badge badge-blue">In Progress</span>
            @else
              <span class="badge badge-teal">Completed</span>
            @endif

            {{-- Update Status Button --}}
            <button type="button" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.72rem;" onclick="openUpdateModal({{ json_encode($m) }})">
              Update
            </button>
          </div>
        </div>

      </div>
    @endforeach
  @endif
</section>

{{-- PAGINATION --}}
@if($maintenances->hasPages())
  <div class="pagination-wrap" style="margin-bottom: 24px;">
    <div>
      Menampilkan {{ $maintenances->firstItem() }} - {{ $maintenances->lastItem() }} dari {{ $maintenances->total() }} agenda
    </div>
    <nav>
      {{-- Previous Page Link --}}
      @if ($maintenances->onFirstPage())
        <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
      @else
        <a href="{{ $maintenances->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
      @endif

      {{-- Pagination Elements --}}
      @foreach ($maintenances->getUrlRange(1, $maintenances->lastPage()) as $page => $url)
        @if ($page == $maintenances->currentPage())
          <span class="active-page">{{ $page }}</span>
        @else
          <a href="{{ $url }}">{{ $page }}</a>
        @endif
      @endforeach

      {{-- Next Page Link --}}
      @if ($maintenances->hasMorePages())
        <a href="{{ $maintenances->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
      @else
        <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
      @endif
    </nav>
  </div>
@endif

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  3. FORM MODAL TAMBAH MAINTENANCE                           --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="modal" id="createModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Tambah Agenda Maintenance</h3>
      <button class="modal-close" onclick="closeCreateModal()">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.maintenances.store') }}">
      @csrf
      <div class="modal-body">
        
        {{-- Laptop Selector --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Pilih Laptop <span>*</span></label>
          <select name="laptop_id" class="f-select" required>
            <option value="">Pilih Unit Laptop...</option>
            @foreach($laptops as $lap)
              <option value="{{ $lap->id }}" {{ old('laptop_id') == $lap->id ? 'selected' : '' }}>
                {{ $lap->code }} - {{ $lap->brand }} {{ $lap->model }} (Kondisi: {{ ucfirst($lap->condition) }})
              </option>
            @endforeach
          </select>
        </div>

        {{-- Status Awal --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Status Awal <span>*</span></label>
          <select name="status" class="f-select" required>
            <option value="pending">Pending (Mengantre)</option>
            <option value="in_progress">In Progress (Sedang Diperbaiki)</option>
          </select>
        </div>

        {{-- Biaya Estimasi --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Estimasi Biaya Perbaikan (Rp)</label>
          <div class="f-input-wrapper">
            <i class="ti ti-wallet"></i>
            <input type="number" name="repair_cost" class="f-input" placeholder="0" min="0" value="0">
          </div>
        </div>

        {{-- Deskripsi Masalah --}}
        <div class="field" style="margin-bottom: 0;">
          <label class="f-label">Deskripsi Masalah / Kerusakan <span>*</span></label>
          <textarea name="issue" class="f-input" style="height: 100px; padding: 10px; resize: none;" placeholder="Contoh: Keyboard tombol 'W' tidak merespon, layar kedap-kedip..." required>{{ old('issue') }}</textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Agenda</button>
      </div>
    </form>
  </div>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  FORM MODAL UPDATE STATUS MAINTENANCE                       --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="modal" id="updateModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title">Update Status Maintenance</h3>
      <button class="modal-close" onclick="closeUpdateModal()">&times;</button>
    </div>
    <form id="updateForm" method="POST" action="">
      @csrf
      @method('PUT')
      <div class="modal-body">
        
        <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:10px; padding:12px; margin-bottom:16px;">
          <div style="font-size:0.75rem; font-weight:600; color:var(--muted); text-transform:uppercase;">Unit Laptop</div>
          <div id="update-laptop-name" style="font-size:0.85rem; font-weight:700; color:var(--text); margin-top:2px;"></div>
        </div>

        {{-- Status Update --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Status Perbaikan</label>
          <select name="status" id="update-status" class="f-select" required>
            <option value="pending">Pending (Mengantre)</option>
            <option value="in_progress">In Progress (Sedang Diperbaiki)</option>
            <option value="completed">Completed (Selesai & Tersedia Kembali)</option>
          </select>
        </div>

        {{-- Biaya Aktual --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Biaya Perbaikan Aktual (Rp)</label>
          <div class="f-input-wrapper">
            <i class="ti ti-wallet"></i>
            <input type="number" name="repair_cost" id="update-cost" class="f-input" placeholder="0" min="0" required>
          </div>
        </div>

        {{-- Deskripsi Masalah (Bisa diedit) --}}
        <div class="field" style="margin-bottom: 0;">
          <label class="f-label">Deskripsi Masalah / Catatan Perbaikan</label>
          <textarea name="issue" id="update-issue" class="f-input" style="height: 80px; padding: 10px; resize: none;" required></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeUpdateModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
// Open/Close Create Modal
function openCreateModal() {
  document.getElementById('createModal').classList.add('show');
}
function closeCreateModal() {
  document.getElementById('createModal').classList.remove('show');
}

// Open/Close Update Status Modal
function openUpdateModal(maint) {
  var form = document.getElementById('updateForm');
  form.action = '/admin/maintenances/' + maint.id;
  
  document.getElementById('update-laptop-name').textContent = maint.laptop.code + ' - ' + maint.laptop.brand + ' ' + maint.laptop.model;
  document.getElementById('update-status').value = maint.status;
  document.getElementById('update-cost').value = Math.round(maint.repair_cost);
  document.getElementById('update-issue').value = maint.issue;
  
  document.getElementById('updateModal').classList.add('show');
}
function closeUpdateModal() {
  document.getElementById('updateModal').classList.remove('show');
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
