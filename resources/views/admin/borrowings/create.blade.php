@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')
@section('page_title', 'Input Peminjaman Baru')
@section('breadcrumb')
  <a href="{{ route('admin.borrowings.index') }}">Peminjaman</a>
  <span>/</span>
  <span style="color:#64748b">Tambah</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM CARD FORM STYLING ──────────────────────────── */
.form-container {
  max-width: 42rem; /* max-w-2xl */
  margin: 0 auto;
  padding-bottom: 40px;
}
.form-card {
  background: #ffffff; /* bg-white */
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  padding: 32px;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.03), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
}
.form-header {
  margin-bottom: 28px;
  border-bottom: 1px solid #f3f4f6;
  padding-bottom: 16px;
}
.form-title {
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--navy);
  display: flex;
  align-items: center;
  gap: 10px;
}
.form-title i {
  color: #0D9F7A; /* teal */
  font-size: 1.35rem;
}
.form-subtitle {
  font-size: 0.78rem;
  color: var(--muted);
  margin-top: 4px;
}

/* Form Fields Styling */
.form-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}
@media(min-width: 640px) {
  .form-grid-2col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
  }
}
.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.form-label {
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--text);
  display: flex;
  align-items: center;
}
.form-label .req {
  color: #ef4444;
  margin-left: 3px;
}
.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.input-wrapper i {
  position: absolute;
  left: 16px;
  color: #94a3b8;
  font-size: 1.15rem;
  pointer-events: none;
  transition: color 0.15s ease;
}
.input-field {
  width: 100%;
  background: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 11px 16px 11px 44px; /* px-4 py-2.5 + extra left padding for icon */
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  color: var(--text);
  outline: none;
  transition: all 0.2s ease;
}
.input-field:focus {
  border-color: #0D9F7A;
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(13, 159, 122, 0.12);
}
.input-field:focus + i {
  color: #0D9F7A;
}

/* Select overrides */
.select-field {
  padding-right: 36px;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  background-size: 14px;
}

/* Textarea overrides */
.textarea-field {
  min-height: 100px;
  resize: vertical;
  padding-left: 44px;
}

/* Input Error Highlight */
.input-field.is-invalid {
  border-color: #ef4444 !important;
  background-color: #fdf2f2 !important;
}
.input-field.is-invalid:focus {
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12) !important;
}
.input-field.is-invalid + i {
  color: #ef4444 !important;
}
.error-text {
  font-size: 0.72rem;
  color: #ef4444;
  font-weight: 500;
  margin-top: 2px;
}

/* Buttons actions */
.form-actions {
  margin-top: 32px;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 12px;
  border-top: 1px solid #f3f4f6;
  padding-top: 20px;
}
.btn-save {
  background: #0D9F7A; /* bg-[#0D9F7A] */
  color: #ffffff !important;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px; /* px-5 py-2.5 */
  font-weight: 600;
  font-size: 0.85rem;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
  box-shadow: 0 4px 10px rgba(13, 159, 122, 0.15);
  text-decoration: none;
}
.btn-save:hover {
  background: #0b8a6a; /* hover:bg-[#0b8a6a] */
  transform: translateY(-1px);
  box-shadow: 0 6px 14px rgba(13, 159, 122, 0.25);
}
.btn-cancel {
  background: #ffffff; /* bg-white */
  color: var(--text);
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px; /* px-5 py-2.5 */
  font-weight: 600;
  font-size: 0.85rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  text-decoration: none;
  transition: all 0.15s ease;
}
.btn-cancel:hover {
  background: #f9fafb;
  border-color: #cbd5e1;
}
</style>

<div class="form-container">
  
  {{-- Form Card --}}
  <div class="form-card">
    <div class="form-header">
      <h2 class="form-title">
        <i class="ti ti-circle-plus"></i> Input Peminjaman Baru
      </h2>
      <p class="form-subtitle">Formulir pendaftaran transaksi peminjaman laptop langsung oleh administrator.</p>
    </div>

    <form method="POST" action="{{ route('admin.borrowings.store') }}">
      @csrf
      
      <div class="form-grid">
        
        {{-- Nama Peminjam --}}
        <div class="form-group">
          <label class="form-label" for="borrower_name">
            Nama Peminjam <span class="req">*</span>
          </label>
          <div class="input-wrapper">
            <input type="text" 
                   id="borrower_name" 
                   name="borrower_name" 
                   class="input-field @error('borrower_name') is-invalid @enderror" 
                   placeholder="Masukkan nama lengkap peminjam..." 
                   value="{{ old('borrower_name') }}" 
                   required>
            <i class="ti ti-user"></i>
          </div>
          @error('borrower_name')
            <span class="error-text"><i class="ti ti-alert-circle"></i> {{ $message }}</span>
          @enderror
        </div>

        {{-- Pilih Laptop --}}
        <div class="form-group">
          <label class="form-label" for="laptop_id">
            Pilih Laptop <span class="req">*</span>
          </label>
          <div class="input-wrapper">
            <select id="laptop_id" 
                    name="laptop_id" 
                    class="input-field select-field @error('laptop_id') is-invalid @enderror" 
                    required>
              <option value="" disabled selected>Pilih Laptop Unit Tersedia...</option>
              @forelse($laptops as $laptop)
                <option value="{{ $laptop->id }}" {{ old('laptop_id') == $laptop->id ? 'selected' : '' }}>
                  {{ $laptop->formatted_id }} — {{ $laptop->brand }} {{ $laptop->model }} (Tersedia)
                </option>
              @empty
                <option value="" disabled>Tidak ada laptop yang tersedia saat ini</option>
              @endforelse
            </select>
            <i class="ti ti-device-laptop"></i>
          </div>
          @error('laptop_id')
            <span class="error-text"><i class="ti ti-alert-circle"></i> {{ $message }}</span>
          @enderror
        </div>

        {{-- Keperluan --}}
        <div class="form-group">
          <label class="form-label" for="purpose">
            Keperluan Peminjaman <span class="req">*</span>
          </label>
          <div class="input-wrapper">
            <input type="text" 
                   id="purpose" 
                   name="purpose" 
                   class="input-field @error('purpose') is-invalid @enderror" 
                   placeholder="Misal: Tugas Akhir, Ujian Praktikum, KKN..." 
                   value="{{ old('purpose') }}" 
                   required>
            <i class="ti ti-file-text"></i>
          </div>
          @error('purpose')
            <span class="error-text"><i class="ti ti-alert-circle"></i> {{ $message }}</span>
          @enderror
        </div>

        {{-- Tanggal Pinjam & Kembali Grid --}}
        <div class="form-grid-2col">
          
          {{-- Tanggal Pinjam --}}
          <div class="form-group">
            <label class="form-label" for="borrow_date">
              Tanggal Pinjam <span class="req">*</span>
            </label>
            <div class="input-wrapper">
              <input type="date" 
                     id="borrow_date" 
                     name="borrow_date" 
                     class="input-field @error('borrow_date') is-invalid @enderror" 
                     value="{{ old('borrow_date', date('Y-m-d')) }}" 
                     required>
              <i class="ti ti-calendar"></i>
            </div>
            @error('borrow_date')
              <span class="error-text"><i class="ti ti-alert-circle"></i> {{ $message }}</span>
            @enderror
          </div>

          {{-- Tanggal Kembali --}}
          <div class="form-group">
            <label class="form-label" for="return_date">
              Tanggal Kembali <span class="req">*</span>
            </label>
            <div class="input-wrapper">
              <input type="date" 
                     id="return_date" 
                     name="return_date" 
                     class="input-field @error('return_date') is-invalid @enderror" 
                     value="{{ old('return_date') }}" 
                     required>
              <i class="ti ti-calendar-due"></i>
            </div>
            @error('return_date')
              <span class="error-text"><i class="ti ti-alert-circle"></i> {{ $message }}</span>
            @enderror
          </div>

        </div>

        {{-- Status --}}
        <div class="form-group">
          <label class="form-label" for="status">
            Status Transaksi <span class="req">*</span>
          </label>
          <div class="input-wrapper">
            <select id="status" 
                    name="status" 
                    class="input-field select-field @error('status') is-invalid @enderror" 
                    required>
              <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="approved" {{ old('status') === 'approved' ? 'selected' : '' }}>Approved</option>
              <option value="borrowed" {{ old('status') === 'borrowed' ? 'selected' : '' }}>Borrowed (Sedang Dipinjam)</option>
            </select>
            <i class="ti ti-bell"></i>
          </div>
          @error('status')
            <span class="error-text"><i class="ti ti-alert-circle"></i> {{ $message }}</span>
          @enderror
        </div>

        {{-- Catatan Admin --}}
        <div class="form-group">
          <label class="form-label" for="admin_note">
            Catatan Admin <span style="font-weight:normal; color:var(--muted); margin-left:3px;">(Opsional)</span>
          </label>
          <div class="input-wrapper">
            <textarea id="admin_note" 
                      name="admin_note" 
                      class="input-field textarea-field @error('admin_note') is-invalid @enderror" 
                      placeholder="Masukkan catatan administratif tambahan jika diperlukan...">{{ old('admin_note') }}</textarea>
            <i class="ti ti-notes" style="top:15px; align-self: flex-start;"></i>
          </div>
          @error('admin_note')
            <span class="error-text"><i class="ti ti-alert-circle"></i> {{ $message }}</span>
          @enderror
        </div>

      </div>

      {{-- Action Buttons --}}
      <div class="form-actions">
        <a href="{{ route('admin.borrowings.index') }}" class="btn-cancel">
          <i class="ti ti-arrow-left"></i> Batal
        </a>
        <button type="submit" class="btn-save">
          <i class="ti ti-device-floppy"></i> Simpan Peminjaman
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
