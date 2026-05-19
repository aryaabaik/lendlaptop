@extends('layouts.admin')

@section('title', 'Kelola Laptop')
@section('page_title', 'Kelola Laptop')
@section('breadcrumb')
  <span>Kelola Laptop</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM LAPTOP CRUD STYLING SYSTEM ───────────────────── */
:root {
  --teal: #0D9F7A;
  --teal-hover: #0b8a6a;
  --navy: #0A1628;
}

.laptop-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  gap: 16px;
}
.laptop-title {
  font-size: 1.35rem;
  font-weight: 700;
  color: var(--navy);
  font-family: 'Inter', sans-serif;
}

/* Card Styling: bg-white, rounded-xl, border border-gray-100 */
.card-premium {
  background: #ffffff;
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  box-shadow: 0 1px 3px rgba(0,0,0,.02), 0 1px 2px rgba(0,0,0,.01);
  padding: 24px;
  margin-bottom: 24px;
}

/* Buttons Styling: bg-[#0D9F7A] text-white hover:bg-[#0b8a6a] rounded-lg px-5 py-2.5 */
.btn-primary-themed {
  background: #0D9F7A;
  color: #ffffff !important;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px; /* px-5 py-2.5 equivalent */
  font-family: 'Inter', sans-serif;
  font-weight: 600;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  transition: all 0.2s ease;
  font-size: 0.85rem;
}
.btn-primary-themed:hover {
  background: #0b8a6a;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(13,159,122,0.18);
}

.btn-secondary-themed {
  background: #ffffff;
  color: #4b5563 !important;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px; /* px-5 py-2.5 */
  font-family: 'Inter', sans-serif;
  font-weight: 600;
  border: 1px solid #e5e7eb; /* border-gray-200 */
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  transition: all 0.2s ease;
  font-size: 0.85rem;
}
.btn-secondary-themed:hover {
  background: #f9fafb;
  border-color: #cbd5e1;
}

/* Input Fields: bg-gray-50 border-gray-200 rounded-lg px-4 py-2.5 + left icon */
.f-label {
  display: block;
  font-size: 0.75rem;
  font-weight: 600;
  color: #6b7280;
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  font-family: 'Inter', sans-serif;
}
.f-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.f-input-wrapper i {
  position: absolute;
  left: 16px;
  color: #9ca3af;
  font-size: 1.05rem;
  pointer-events: none;
}
.f-input {
  width: 100%;
  background: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 16px 10px 44px; /* px-4 py-2.5 + space for left icon */
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  color: #1f2937;
  outline: none;
  transition: all 0.2s ease;
}
.f-input:focus {
  border-color: #0D9F7A;
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(13,159,122,0.12);
}

.f-select {
  width: 100%;
  background: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 40px 10px 44px; /* px-4 py-2.5 + space for left icon + drop-down space */
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  color: #1f2937;
  outline: none;
  cursor: pointer;
  transition: all 0.2s ease;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 16px center;
  background-size: 12px;
}
.f-select:focus {
  border-color: #0D9F7A;
  background-color: #ffffff;
}

/* Badge status: tersedia=teal pill, dipinjam=blue pill */
.badge-status {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 12px;
  border-radius: 9999px; /* pill */
  font-size: 0.75rem;
  font-weight: 600;
  line-height: 1.5;
  font-family: 'Inter', sans-serif;
}
.badge-status-tersedia {
  background: rgba(13, 159, 122, 0.1);
  color: #0D9F7A;
}
.badge-status-dipinjam {
  background: rgba(59, 130, 246, 0.1);
  color: #3B82F6;
}

/* Table Style */
.tbl-card {
  background: #ffffff;
  border-radius: 0.75rem;
  border: 1px solid #f3f4f6;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  overflow: hidden;
  margin-bottom: 24px;
}
.tbl-responsive {
  width: 100%;
  overflow-x: auto;
}
.laptop-tbl {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 0.85rem;
  font-family: 'Inter', sans-serif;
}
.laptop-tbl th {
  padding: 14px 18px;
  background: #f9fafb;
  color: #6b7280;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.72rem;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e5e7eb;
}
.laptop-tbl td {
  padding: 14px 18px;
  border-bottom: 1px solid #f3f4f6;
  color: #1f2937;
  vertical-align: middle;
}
.laptop-tbl tr:last-child td {
  border-bottom: none;
}

/* Action button configurations */
.btn-action-group {
  display: flex;
  align-items: center;
  gap: 6px;
}
.btn-act {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: none;
  font-size: 1rem;
  transition: all 0.15s ease;
  background: none;
  text-decoration: none;
}
.btn-act-edit {
  background: rgba(59, 130, 246, 0.08);
  color: #3B82F6;
}
.btn-act-edit:hover {
  background: #3B82F6;
  color: #ffffff;
  box-shadow: 0 3px 8px rgba(59, 130, 246, 0.2);
}
.btn-act-trash {
  background: rgba(239, 68, 68, 0.08);
  color: #ef4444;
}
.btn-act-trash:hover:not(:disabled) {
  background: #ef4444;
  color: #ffffff;
  box-shadow: 0 3px 8px rgba(239, 68, 68, 0.2);
}
.btn-act-trash:disabled {
  opacity: 0.4;
  cursor: not-allowed;
  background: rgba(156, 163, 175, 0.08) !important;
  color: #9ca3af !important;
}

/* Pagination Wrap */
.pagination-wrap {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-top: 1px solid #e5e7eb;
  background: #ffffff;
  font-size: 0.8rem;
  font-family: 'Inter', sans-serif;
  color: #6b7280;
}
.pagination-wrap nav {
  display: inline-flex;
  border-radius: 8px;
  overflow: hidden;
}
.pagination-wrap span, .pagination-wrap a {
  padding: 8px 14px;
  border: 1px solid #e5e7eb;
  background: #ffffff;
  color: #6b7280;
  text-decoration: none;
  font-weight: 500;
  transition: all 0.2s;
  margin-left: -1px;
}
.pagination-wrap a:hover {
  background: #f9fafb;
  color: #1f2937;
}
.pagination-wrap .active-page {
  background: var(--teal) !important;
  color: #ffffff !important;
  border-color: var(--teal) !important;
}

/* Modals System CSS */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 1000;
  background: rgba(10, 22, 40, 0.5);
  backdrop-filter: blur(4px);
  display: none;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
.modal-overlay.show {
  display: flex;
}
.modal-box {
  background: #ffffff;
  border-radius: 1rem;
  width: 100%;
  max-width: 480px;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
  overflow: hidden;
  animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  display: flex;
  flex-direction: column;
}
@keyframes modalPop {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.modal-header {
  padding: 18px 24px;
  background: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: var(--navy);
  font-family: 'Inter', sans-serif;
}
.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #9ca3af;
  line-height: 1;
  transition: color 0.15s;
}
.modal-close:hover {
  color: #4b5563;
}
.modal-body {
  padding: 24px;
}
.modal-footer {
  padding: 16px 24px;
  background: #f9fafb;
  border-top: 1px solid #e5e7eb;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}
</style>

<div class="laptop-header">
  <h1 class="laptop-title">Kelola Laptop</h1>
  <button class="btn-primary-themed" onclick="openCreateModal()">
    <i class="ti ti-plus"></i> Tambah Laptop
  </button>
</div>

{{-- FILTER SECTION --}}
<section class="card-premium" style="padding: 20px;">
  <form method="GET" action="{{ route('admin.laptops.index') }}">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)) auto; gap: 16px; align-items: flex-end;">
      
      {{-- Search --}}
      <div>
        <label class="f-label">Cari Laptop</label>
        <div class="f-input-wrapper">
          <i class="ti ti-search"></i>
          <input type="text" name="search" class="f-input" value="{{ request('search') }}" placeholder="Cari merk atau model...">
        </div>
      </div>

      {{-- Filter Status --}}
      <div>
        <label class="f-label">Status</label>
        <div class="f-input-wrapper">
          <i class="ti ti-info-circle"></i>
          <select name="status" class="f-select">
            <option value="">Semua Status</option>
            <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
          </select>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div style="display: flex; gap: 8px;">
        <button type="submit" class="btn-primary-themed" style="padding: 9.5px 20px;">
          <i class="ti ti-filter"></i> Filter
        </button>
        <a href="{{ route('admin.laptops.index') }}" class="btn-secondary-themed" style="padding: 9.5px 20px;">
          Reset
        </a>
      </div>

    </div>
  </form>
</section>

{{-- LAPTOP TABLE CARD --}}
<section class="tbl-card">
  <div class="tbl-responsive">
    @if($laptops->isEmpty())
      <div style="text-align: center; padding: 60px 20px; color: #9ca3af; font-family: 'Inter', sans-serif;">
        <i class="ti ti-device-laptop-off" style="font-size: 3.5rem; margin-bottom: 16px; display: block; opacity: 0.4; color: var(--teal);"></i>
        <h3 style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 4px;">Tidak ada laptop ditemukan</h3>
        <p style="font-size: 0.82rem;">Silakan tambahkan data laptop baru ke dalam sistem.</p>
      </div>
    @else
      <table class="laptop-tbl">
        <thead>
          <tr>
            <th style="width: 60px; text-align: center;">#</th>
            <th>Merk</th>
            <th>Model</th>
            <th>Status</th>
            <th style="text-align: center; width: 160px;">Jumlah Dipinjam</th>
            <th style="text-align: center; width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($laptops as $i => $laptop)
            <tr>
              <td style="text-align: center; color: #9ca3af; font-weight: 600;">
                {{ $laptops->firstItem() + $i }}
              </td>
              <td style="font-weight: 700; color: var(--navy);">
                {{ $laptop->brand }}
              </td>
              <td style="font-weight: 500;">
                <div>{{ $laptop->model }}</div>
                <div style="font-size: 0.72rem; color: #9ca3af;">{{ $laptop->category?->name ?? 'Tanpa Kategori' }}</div>
              </td>
              <td>
                @if($laptop->status === 'tersedia')
                  <span class="badge-status badge-status-tersedia">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #0D9F7A;"></span>
                    Tersedia
                  </span>
                @else
                  <span class="badge-status badge-status-dipinjam">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #3B82F6;"></span>
                    Dipinjam
                  </span>
                @endif
              </td>
              <td style="text-align: center; font-weight: 600; color: #4b5563;">
                {{ $laptop->borrowings_count ?? 0 }} kali
              </td>
              <td>
                <div class="btn-action-group" style="justify-content: center;">
                  {{-- Edit --}}
                  <button type="button" class="btn-act btn-act-edit" onclick="openEditModal({{ json_encode($laptop) }})" title="Edit Laptop">
                    <i class="ti ti-edit"></i>
                  </button>
                  
                  {{-- Delete (Disabled if borrowed) --}}
                  @if($laptop->status === 'dipinjam')
                    <button type="button" class="btn-act btn-act-trash" disabled title="Laptop sedang dipinjam (tidak dapat dihapus)">
                      <i class="ti ti-trash"></i>
                    </button>
                  @else
                    <button type="button" class="btn-act btn-act-trash" onclick="openDeleteModal({{ $laptop->id }}, '{{ $laptop->brand }} {{ $laptop->model }}')" title="Hapus Laptop">
                      <i class="ti ti-trash"></i>
                    </button>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  @if($laptops->hasPages())
    <div class="pagination-wrap">
      <div>
        Menampilkan {{ $laptops->firstItem() }} - {{ $laptops->lastItem() }} dari {{ $laptops->total() }} laptop
      </div>
      <nav>
        @if ($laptops->onFirstPage())
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $laptops->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        @foreach ($laptops->getUrlRange(1, $laptops->lastPage()) as $page => $url)
          @if ($page == $laptops->currentPage())
            <span class="active-page">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        @if ($laptops->hasMorePages())
          <a href="{{ $laptops->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif
</section>

{{-- MODAL: TAMBAH LAPTOP --}}
<div class="modal-overlay" id="createModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3 class="modal-title">Tambah Laptop Baru</h3>
      <button class="modal-close" onclick="closeCreateModal()">&times;</button>
    </div>
    <form method="POST" action="{{ route('admin.laptops.store') }}">
      @csrf
      <div class="modal-body">
        
        {{-- Merk Input --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Merk <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-building"></i>
            <input type="text" name="brand" class="f-input" placeholder="Contoh: Lenovo, ASUS, HP" required>
          </div>
        </div>

        {{-- Model Input --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Model / Tipe <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-device-laptop"></i>
            <input type="text" name="model" class="f-input" placeholder="Contoh: ThinkPad E14, VivoBook 14" required>
          </div>
        </div>

        {{-- Status Dropdown --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Status Awal <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-info-circle"></i>
            <select name="status" class="f-select" required>
              <option value="tersedia">Tersedia</option>
              <option value="dipinjam">Dipinjam</option>
            </select>
          </div>
        </div>

        {{-- Category Dropdown --}}
        <div class="field" style="margin-bottom: 0;">
          <label class="f-label">Kategori Laptop</label>
          <div class="f-input-wrapper">
            <i class="ti ti-tag"></i>
            <select name="category_id" class="f-select">
              <option value="">Tanpa Kategori</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-secondary-themed" onclick="closeCreateModal()">Batal</button>
        <button type="submit" class="btn-primary-themed">Simpan Laptop</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL: EDIT LAPTOP --}}
<div class="modal-overlay" id="editModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3 class="modal-title">Edit Data Laptop</h3>
      <button class="modal-close" onclick="closeEditModal()">&times;</button>
    </div>
    <form id="editForm" method="POST" action="">
      @csrf
      @method('PUT')
      <div class="modal-body">
        
        {{-- Merk Input --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Merk <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-building"></i>
            <input type="text" name="brand" id="edit-brand" class="f-input" required>
          </div>
        </div>

        {{-- Model Input --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Model / Tipe <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-device-laptop"></i>
            <input type="text" name="model" id="edit-model" class="f-input" required>
          </div>
        </div>

        {{-- Status Dropdown --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Status Laptop <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-info-circle"></i>
            <select name="status" id="edit-status" class="f-select" required>
              <option value="tersedia">Tersedia</option>
              <option value="dipinjam">Dipinjam</option>
            </select>
          </div>
        </div>

        {{-- Category Dropdown --}}
        <div class="field" style="margin-bottom: 0;">
          <label class="f-label">Kategori Laptop</label>
          <div class="f-input-wrapper">
            <i class="ti ti-tag"></i>
            <select name="category_id" id="edit-category" class="f-select">
              <option value="">Tanpa Kategori</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-secondary-themed" onclick="closeEditModal()">Batal</button>
        <button type="submit" class="btn-primary-themed">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL: KONFIRMASI HAPUS --}}
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box" style="max-width: 400px;">
    <div class="modal-header" style="background: #ffffff; border-bottom: none; padding-bottom: 0;">
      <h3 class="modal-title" style="color: #ef4444; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
        <i class="ti ti-alert-triangle"></i> Konfirmasi Hapus
      </h3>
      <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
    </div>
    <form id="deleteForm" method="POST" action="">
      @csrf
      @method('DELETE')
      <div class="modal-body" style="padding: 16px 24px 24px;">
        <p style="font-size: 0.85rem; color: #4b5563; line-height: 1.5; font-family: 'Inter', sans-serif;">
          Apakah Anda yakin ingin menghapus data laptop <strong id="deleteLaptopName" style="color: var(--navy);"></strong>?
        </p>
      </div>
      <div class="modal-footer" style="background: #f9fafb; border-top: 1px solid #e5e7eb;">
        <button type="button" class="btn-secondary-themed" style="padding: 8px 16px;" onclick="closeDeleteModal()">Batalkan</button>
        <button type="submit" class="btn-primary-themed" style="padding: 8px 16px; background: #ef4444;">Ya, Hapus</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function openCreateModal() {
  document.getElementById('createModal').classList.add('show');
}
function closeCreateModal() {
  document.getElementById('createModal').classList.remove('show');
}

function openEditModal(laptop) {
  var form = document.getElementById('editForm');
  form.action = '/admin/laptops/' + laptop.id;
  
  document.getElementById('edit-brand').value = laptop.brand;
  document.getElementById('edit-model').value = laptop.model;
  document.getElementById('edit-status').value = laptop.status;
  document.getElementById('edit-category').value = laptop.category_id || '';
  
  document.getElementById('editModal').classList.add('show');
}
function closeEditModal() {
  document.getElementById('editModal').classList.remove('show');
}

function openDeleteModal(id, laptopName) {
  var form = document.getElementById('deleteForm');
  form.action = '/admin/laptops/' + id;
  
  document.getElementById('deleteLaptopName').textContent = laptopName;
  document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
  document.getElementById('deleteModal').classList.remove('show');
}

// Global form processor visual loader
document.querySelectorAll('form').forEach(function(f){
  f.addEventListener('submit', function(e){
    // Skip if it is the filter/search form
    if(f.action && f.action.includes('search=')) return;
    
    var btn = f.querySelector('.btn-primary-themed');
    if(btn){
      btn.innerHTML = '<i class="ti ti-loader animate-spin" style="margin-right: 4px;"></i> Memproses...';
      btn.disabled = true;
      btn.style.opacity = '.75';
    }
  });
});
</script>
@endpush
@endsection
