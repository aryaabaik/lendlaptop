@extends('layouts.admin')

@section('title', 'Kategori Laptop')
@section('page_title', 'Kategori Laptop')
@section('breadcrumb')
  <span>Kategori</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM CATEGORIES STYLES ───────────────────────────── */
.cat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
}
.cat-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--text);
}

/* Category Grid */
.cat-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 20px;
  margin-bottom: 24px;
}
.cat-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 24px;
  display: flex;
  flex-direction: column;
  transition: all .2s;
}
.cat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 20px -8px rgba(10,22,40,.06);
  border-color: var(--teal-border);
}

.cat-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 16px;
}
.cat-icon-box {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: var(--teal-dim);
  color: var(--teal);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  transition: all .2s;
}
.cat-card:hover .cat-icon-box {
  background: var(--teal);
  color: #fff;
  box-shadow: 0 4px 10px rgba(13,159,122,.25);
}

.cat-count-badge {
  background: #f1f5f9;
  color: var(--muted);
  font-size: .74rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 999px;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}

.cat-name {
  font-size: 1rem;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 8px;
}
.cat-desc {
  font-size: .8rem;
  color: var(--muted);
  line-height: 1.5;
  margin-bottom: 20px;
  flex-grow: 1;
}

.cat-actions {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 8px;
  border-top: 1px solid #f1f5f9;
  padding-top: 14px;
  margin-top: auto;
}
.cat-btn {
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
}
.cat-btn-secondary {
  background: #f1f5f9;
  color: var(--muted);
}
.cat-btn-secondary:hover {
  background: #cbd5e1;
  color: var(--text);
}
.cat-btn-red {
  background: rgba(239,68,68,.06);
  color: var(--red);
}
.cat-btn-red:hover {
  background: var(--red);
  color: #fff;
  box-shadow: 0 4px 8px rgba(239,68,68,.15);
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
  max-width: 440px;
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
</style>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  1. HEADER                                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="cat-header">
  <h1 class="cat-title">Kategori Laptop</h1>
  <button class="btn btn-primary" onclick="openCreateModal()">
    <i class="ti ti-plus"></i> Tambah Kategori
  </button>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  2. GRID KARTU KATEGORI (3 kolom)                         --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="cat-grid">
  @if($categories->isEmpty())
    <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background:#fff; border-radius:1rem; border:1px solid #f1f5f9;">
      <i class="ti ti-tags" style="font-size: 3rem; color:var(--muted); margin-bottom:12px; display:block; opacity:0.5;"></i>
      Belum ada kategori terdaftar. Silakan tambahkan baru.
    </div>
  @else
    @foreach($categories as $c)
      <div class="cat-card">
        
        {{-- Card Top Row --}}
        <div class="cat-top">
          <div class="cat-icon-box">
            @if(stripos($c->name, 'gaming') !== false)
              <i class="ti ti-device-gamepad-2"></i>
            @elseif(stripos($c->name, 'ultrabook') !== false || stripos($c->name, 'tipis') !== false)
              <i class="ti ti-device-laptop"></i>
            @elseif(stripos($c->name, 'server') !== false || stripos($c->name, 'workstation') !== false)
              <i class="ti ti-server"></i>
            @else
              <i class="ti ti-tag"></i>
            @endif
          </div>

          <div class="cat-count-badge">
            <i class="ti ti-devices"></i> {{ $c->laptops_count }} unit
          </div>
        </div>

        {{-- Nama & Deskripsi --}}
        <h3 class="cat-name">{{ $c->name }}</h3>
        <p class="cat-desc">
          {{ $c->description ?? 'Tidak ada deskripsi detail untuk kategori ini.' }}
        </p>

        {{-- Actions --}}
        <div class="cat-actions">
          
          {{-- Edit Trigger --}}
          <button type="button" class="cat-btn cat-btn-secondary" onclick="openEditModal({{ json_encode($c) }})">
            <i class="ti ti-edit"></i> Edit
          </button>

          {{-- Delete Trigger --}}
          <form method="POST" action="{{ route('admin.categories.destroy', $c->id) }}" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="cat-btn cat-btn-red">
              <i class="ti ti-trash"></i> Hapus
            </button>
          </form>

        </div>

      </div>
    @endforeach
  @endif
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  3. FORM MODAL ADD/EDIT                                    --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="modal" id="catModal">
  <div class="modal-content">
    <div class="modal-header">
      <h3 class="modal-title" id="modal-title-el">Tambah Kategori Baru</h3>
      <button class="modal-close" onclick="closeCatModal()">&times;</button>
    </div>
    <form id="catForm" method="POST" action="">
      @csrf
      <input type="hidden" name="_method" id="form-method-override" value="POST">
      
      <div class="modal-body">
        
        {{-- Nama Kategori --}}
        <div class="field" style="margin-bottom: 16px;">
          <label class="f-label">Nama Kategori <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-tag"></i>
            <input type="text" name="name" id="cat-name" class="f-input" placeholder="Contoh: Gaming / Ultrabook" required>
          </div>
        </div>

        {{-- Deskripsi --}}
        <div class="field" style="margin-bottom: 0;">
          <label class="f-label">Deskripsi Kategori</label>
          <div class="f-input-wrapper" style="align-items: flex-start;">
            <i class="ti ti-text-wrap" style="top: 12px;"></i>
            <textarea name="description" id="cat-desc" class="f-input" style="height: 100px; padding: 10px 10px 10px 42px; resize: none;" placeholder="Tulis deskripsi singkat mengenai spesifikasi atau peruntukan kelompok unit ini..."></textarea>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeCatModal()">Batal</button>
        <button type="submit" class="btn btn-primary" id="btn-submit-el">Simpan Kategori</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
// Open modal for creating
function openCreateModal() {
  var form = document.getElementById('catForm');
  form.action = "{{ route('admin.categories.store') }}";
  document.getElementById('form-method-override').value = 'POST';
  
  document.getElementById('modal-title-el').textContent = 'Tambah Kategori Baru';
  document.getElementById('btn-submit-el').textContent = 'Simpan Kategori';
  
  document.getElementById('cat-name').value = '';
  document.getElementById('cat-desc').value = '';
  
  document.getElementById('catModal').classList.add('show');
}

// Open modal for editing
function openEditModal(cat) {
  var form = document.getElementById('catForm');
  form.action = '/admin/categories/' + cat.id;
  document.getElementById('form-method-override').value = 'PUT';
  
  document.getElementById('modal-title-el').textContent = 'Edit Kategori';
  document.getElementById('btn-submit-el').textContent = 'Simpan Perubahan';
  
  document.getElementById('cat-name').value = cat.name;
  document.getElementById('cat-desc').value = cat.description || '';
  
  document.getElementById('catModal').classList.add('show');
}

function closeCatModal() {
  document.getElementById('catModal').classList.remove('show');
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
