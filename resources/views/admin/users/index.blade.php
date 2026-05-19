@extends('layouts.admin')

@section('title', 'Pengguna')
@section('page_title', 'Pengguna')
@section('breadcrumb')
  <span>Pengguna</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM USERS CRUD STYLING SYSTEM ───────────────────── */
:root {
  --teal: #0D9F7A;
  --teal-hover: #0b8a6a;
  --navy: #0A1628;
}

.users-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  gap: 16px;
}
.users-title {
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

/* Input Fields: bg-gray-50 border-gray-200 rounded-lg px-4 py-2.5 + ikon di kiri */
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

/* Badge status: admin=teal pill, user=blue pill */
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
.badge-status-admin {
  background: rgba(13, 159, 122, 0.1);
  color: #0D9F7A;
}
.badge-status-user {
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
.custom-tbl {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 0.85rem;
  font-family: 'Inter', sans-serif;
}
.custom-tbl th {
  padding: 14px 18px;
  background: #f9fafb;
  color: #6b7280;
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.72rem;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e5e7eb;
}
.custom-tbl td {
  padding: 14px 18px;
  border-bottom: 1px solid #f3f4f6;
  color: #1f2937;
  vertical-align: middle;
}
.custom-tbl tr:last-child td {
  border-bottom: none;
}

/* User Cell */
.user-cell {
  display: flex;
  align-items: center;
  gap: 12px;
}
.user-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: rgba(13, 159, 122, 0.1);
  color: #0D9F7A;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.82rem;
  border: 2px solid #ffffff;
  box-shadow: 0 0 0 1px rgba(13, 159, 122, 0.2);
}
.user-avatar-admin {
  background: rgba(10, 22, 40, 0.08);
  color: #0A1628;
  box-shadow: 0 0 0 1px rgba(10, 22, 40, 0.15);
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
.btn-act-trash:hover {
  background: #ef4444;
  color: #ffffff;
  box-shadow: 0 3px 8px rgba(239, 68, 68, 0.2);
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

<div class="users-header">
  <h1 class="users-title">Pengguna</h1>
  <button class="btn-primary-themed" onclick="openCreateModal()">
    <i class="ti ti-plus"></i> Tambah User
  </button>
</div>

{{-- FILTER SECTION --}}
<section class="card-premium" style="padding: 20px;">
  <form method="GET" action="{{ route('admin.users.index') }}">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)) auto; gap: 16px; align-items: flex-end;">
      
      {{-- Search --}}
      <div>
        <label class="f-label">Cari Pengguna</label>
        <div class="f-input-wrapper">
          <i class="ti ti-search"></i>
          <input type="text" name="search" class="f-input" value="{{ request('search') }}" placeholder="Cari nama atau email...">
        </div>
      </div>

      {{-- Role filter --}}
      <div>
        <label class="f-label">Peran (Role)</label>
        <div class="f-input-wrapper">
          <i class="ti ti-shield"></i>
          <select name="role" class="f-select">
            <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>Semua Peran</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User biasa (Mahasiswa)</option>
          </select>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div style="display: flex; gap: 8px;">
        <button type="submit" class="btn-primary-themed" style="padding: 9.5px 20px;">
          <i class="ti ti-filter"></i> Cari
        </button>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary-themed" style="padding: 9.5px 20px;">
          Reset
        </a>
      </div>

    </div>
  </form>
</section>

{{-- TABEL PENGGUNA --}}
<section class="tbl-card">
  <div class="tbl-responsive">
    @if($users->isEmpty())
      <div style="text-align: center; padding: 60px 20px; color: #9ca3af; font-family: 'Inter', sans-serif;">
        <i class="ti ti-users-minus" style="font-size: 3.5rem; margin-bottom: 16px; display: block; opacity: 0.4; color: var(--teal);"></i>
        <h3 style="font-size: 1rem; font-weight: 600; color: var(--navy); margin-bottom: 4px;">Tidak ada akun pengguna</h3>
        <p style="font-size: 0.82rem;">Tidak ada data pengguna ditemukan.</p>
      </div>
    @else
      <table class="custom-tbl">
        <thead>
          <tr>
            <th style="width: 60px; text-align: center;">#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Kelas</th>
            <th>No. HP</th>
            <th>Role</th>
            <th style="text-align: center; width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $i => $u)
            <tr>
              <td style="text-align: center; color: #9ca3af; font-weight: 600;">
                {{ $users->firstItem() + $i }}
              </td>
              <td>
                <div class="user-cell">
                  <div class="user-avatar {{ $u->role === 'admin' ? 'user-avatar-admin' : '' }}">
                    {{ strtoupper(substr($u->name, 0, 2)) }}
                  </div>
                  <div style="font-weight: 700; color: var(--navy);">{{ $u->name }}</div>
                </div>
              </td>
              <td style="font-family: monospace; font-size: 0.82rem;">{{ $u->email }}</td>
              <td style="font-weight: 500;">{{ $u->kelas ?? '-' }}</td>
              <td style="font-weight: 500;">{{ $u->phone ?? '-' }}</td>
              <td>
                @if($u->role === 'admin')
                  <span class="badge-status badge-status-admin">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #0D9F7A;"></span>
                    Admin
                  </span>
                @else
                  <span class="badge-status badge-status-user">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #3B82F6;"></span>
                    User
                  </span>
                @endif
              </td>
              <td>
                <div class="btn-action-group" style="justify-content: center;">
                  
                  {{-- Edit --}}
                  <button type="button" class="btn-act btn-act-edit" onclick="openEditModal({{ json_encode($u) }})" title="Sunting Data">
                    <i class="ti ti-edit"></i>
                  </button>

                  {{-- Hapus (Disabled on active user) --}}
                  @if($u->id !== Auth::id())
                    <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $u->name }} secara permanen?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn-act btn-act-trash" title="Hapus User">
                        <i class="ti ti-trash"></i>
                      </button>
                    </form>
                  @else
                    <button type="button" class="btn-act btn-act-trash" style="opacity: 0.3; cursor: not-allowed;" disabled title="Akun sedang digunakan (tidak dapat dihapus)">
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

  @if($users->hasPages())
    <div class="pagination-wrap">
      <div>
        Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} akun
      </div>
      <nav>
        @if ($users->onFirstPage())
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $users->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
          @if ($page == $users->currentPage())
            <span class="active-page">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        @if ($users->hasMorePages())
          <a href="{{ $users->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span style="opacity: 0.5; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif
</section>

{{-- MODAL ADD/EDIT USER --}}
<div class="modal-overlay" id="userModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3 class="modal-title" id="modal-title-el">Tambah Akun Pengguna</h3>
      <button class="modal-close" onclick="closeUserModal()">&times;</button>
    </div>
    <form id="userForm" method="POST" action="">
      @csrf
      <input type="hidden" name="_method" id="form-method-override" value="POST">
      
      <div class="modal-body">
        
        {{-- Nama --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Nama <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-user"></i>
            <input type="text" name="name" id="user-name" class="f-input" placeholder="Contoh: Muhammad Rafli" required>
          </div>
        </div>

        {{-- Email --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Email <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-mail"></i>
            <input type="email" name="email" id="user-email" class="f-input" placeholder="contoh@unibi.ac.id" required>
          </div>
        </div>

        {{-- Password --}}
        <div class="field" style="margin-bottom: 20px;" id="password-field-container">
          <label class="f-label" id="password-label">Password <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-lock"></i>
            <input type="password" name="password" id="user-password" class="f-input" placeholder="Minimal 8 karakter">
          </div>
          <p id="password-helper" style="font-size:0.75rem; color:#6b7280; margin-top:6px; display:none; line-height: 1.4;">
            * Biarkan kosong jika tidak ingin mengubah kata sandi akun.
          </p>
        </div>

        {{-- Kelas --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">Kelas</label>
          <div class="f-input-wrapper">
            <i class="ti ti-school"></i>
            <input type="text" name="kelas" id="user-kelas" class="f-input" placeholder="Contoh: IF-A 2023 / Akuntansi">
          </div>
        </div>

        {{-- No. HP --}}
        <div class="field" style="margin-bottom: 20px;">
          <label class="f-label">No. HP</label>
          <div class="f-input-wrapper">
            <i class="ti ti-phone"></i>
            <input type="text" name="phone" id="user-phone" class="f-input" placeholder="Contoh: 081234567890">
          </div>
        </div>

        {{-- Role --}}
        <div class="field" style="margin-bottom: 0;">
          <label class="f-label">Role <span style="color:#ef4444">*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-shield"></i>
            <select name="role" id="user-role" class="f-select" required>
              <option value="user">User biasa (Mahasiswa)</option>
              <option value="admin">Administrator Sistem</option>
            </select>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn-secondary-themed" onclick="closeUserModal()">Batal</button>
        <button type="submit" class="btn-primary-themed" id="btn-submit-el">Simpan Akun</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function openCreateModal() {
  var form = document.getElementById('userForm');
  form.action = "{{ route('admin.users.store') }}";
  document.getElementById('form-method-override').value = 'POST';
  
  document.getElementById('modal-title-el').textContent = 'Tambah Akun Pengguna';
  document.getElementById('btn-submit-el').textContent = 'Simpan Akun';
  
  document.getElementById('user-name').value = '';
  document.getElementById('user-email').value = '';
  document.getElementById('user-password').value = '';
  document.getElementById('user-kelas').value = '';
  document.getElementById('user-phone').value = '';
  document.getElementById('user-role').value = 'user';
  
  document.getElementById('user-password').required = true;
  document.getElementById('password-label').querySelector('span').style.display = 'inline';
  document.getElementById('password-helper').style.display = 'none';
  
  document.getElementById('userModal').classList.add('show');
}

function openEditModal(user) {
  var form = document.getElementById('userForm');
  form.action = '/admin/users/' + user.id;
  document.getElementById('form-method-override').value = 'PUT';
  
  document.getElementById('modal-title-el').textContent = 'Sunting Akun Pengguna';
  document.getElementById('btn-submit-el').textContent = 'Simpan Perubahan';
  
  document.getElementById('user-name').value = user.name;
  document.getElementById('user-email').value = user.email;
  document.getElementById('user-password').value = '';
  document.getElementById('user-kelas').value = user.kelas || '';
  document.getElementById('user-phone').value = user.phone || '';
  document.getElementById('user-role').value = user.role;
  
  document.getElementById('user-password').required = false;
  document.getElementById('password-label').querySelector('span').style.display = 'none';
  document.getElementById('password-helper').style.display = 'block';
  
  document.getElementById('userModal').classList.add('show');
}

function closeUserModal() {
  document.getElementById('userModal').classList.remove('show');
}

// Global loader spinner on form submit
document.querySelectorAll('form').forEach(function(f){
  f.addEventListener('submit', function(e){
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
