@extends('layouts.app')

@section('title', 'Ajukan Peminjaman — ' . $laptop->brand . ' ' . $laptop->model)

@section('content')
<style>
/* ─── THEMING & CARD FORM STYLES ───────────────────────────── */
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

.form-wrapper {
  max-width: 576px; /* max-w-xl */
  margin: 0 auto;
}

/* Card: bg-white, rounded-xl, border border-gray-100 */
.form-card {
  background-color: #fff;
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  box-shadow: 0 4px 20px rgba(10, 22, 40, 0.03);
  padding: 32px;
}

.form-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--navy);
  margin-bottom: 24px;
  border-bottom: 1px solid #f3f4f6;
  padding-bottom: 16px;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--text);
  margin-bottom: 6px;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}
.form-label span {
  color: var(--red);
}

/* Input: bg-gray-50 border-gray-200 rounded-lg px-4 py-2.5 + ikon di kiri */
.input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.input-wrapper i {
  position: absolute;
  left: 16px;
  color: var(--muted);
  font-size: 1.1rem;
  pointer-events: none;
}
.input-control {
  width: 100%;
  background-color: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 16px 10px 44px; /* px-4 py-2.5 */
  font-family: 'Inter', sans-serif;
  font-size: 0.88rem;
  color: var(--text);
  outline: none;
  transition: all 0.2s ease;
}
.input-control:focus {
  border-color: var(--teal);
  background-color: #fff;
  box-shadow: 0 0 0 3px rgba(13,159,122,.12);
}
.input-control:disabled, .input-control[readonly] {
  background-color: #f3f4f6;
  color: var(--muted);
  cursor: not-allowed;
}

/* Action Row Buttons */
.btn-row {
  display: flex;
  gap: 12px;
  margin-top: 28px;
}
.btn-submit {
  flex: 1;
  background-color: var(--teal); /* bg-[#0D9F7A] */
  color: #fff;
  font-weight: 600;
  font-size: 0.88rem;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px; /* px-5 py-2.5 equivalent */
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background 0.2s;
}
.btn-submit:hover {
  background-color: var(--teal-dark); /* hover:bg-[#0b8a6a] */
}

.btn-back {
  background-color: #fff;
  color: var(--text);
  font-weight: 600;
  font-size: 0.88rem;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px; /* px-5 py-2.5 equivalent */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  text-decoration: none;
  text-align: center;
  transition: background 0.2s;
}
.btn-back:hover {
  background-color: #f9fafb;
}

/* Info Box */
.info-box-gray {
  background-color: #f9fafb; /* bg-gray-50 */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 14px 16px;
  margin-top: 24px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  color: var(--muted);
  font-size: 0.82rem;
  line-height: 1.4;
}
.info-box-gray i {
  color: var(--teal);
  font-size: 1.25rem;
  margin-top: 1px;
}

/* Error banner */
.error-banner {
  background-color: rgba(239,68,68,0.06);
  border: 1px solid rgba(239,68,68,0.15);
  border-radius: 0.5rem;
  padding: 12px 16px;
  color: var(--red);
  font-size: 0.82rem;
  margin-bottom: 20px;
}
.error-banner ul {
  margin: 4px 0 0 16px;
  padding: 0;
}
</style>

<div class="form-wrapper">
  
  {{-- Card Form --}}
  <div class="form-card">
    <h1 class="form-title">Ajukan Peminjaman — {{ $laptop->brand }} {{ $laptop->model }}</h1>

    @if ($errors->any())
      <div class="error-banner">
        <strong>Terjadi kesalahan pengisian form:</strong>
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('error'))
      <div class="error-banner">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('user.borrowings.store') }}" id="borrow-form">
      @csrf
      <input type="hidden" name="laptop_id" value="{{ $laptop->id }}">

      {{-- Nama Laptop (Read-Only) --}}
      <div class="form-group">
        <label class="form-label">Nama Laptop</label>
        <div class="input-wrapper">
          <i class="ti ti-device-laptop"></i>
          <input type="text" class="input-control" value="{{ $laptop->brand }} {{ $laptop->model }} ({{ $laptop->code }})" readonly>
        </div>
      </div>

      {{-- Nama Peminjam --}}
      <div class="form-group">
        <label class="form-label">Nama Peminjam <span>*</span></label>
        <div class="input-wrapper">
          <i class="ti ti-user"></i>
          <input type="text" name="borrower_name" class="input-control" value="{{ old('borrower_name', auth()->user()->name) }}" required placeholder="Masukkan nama peminjam...">
        </div>
      </div>

      {{-- Keperluan --}}
      <div class="form-group">
        <label class="form-label">Keperluan <span>*</span></label>
        <div class="input-wrapper">
          <i class="ti ti-file-text"></i>
          <input type="text" name="purpose" class="input-control" value="{{ old('purpose') }}" required placeholder="cth: Tugas Akhir, Ujian Praktikum">
        </div>
      </div>

      {{-- Tanggal Pinjam --}}
      <div class="form-group">
        <label class="form-label">Tanggal Pinjam <span>*</span></label>
        <div class="input-wrapper">
          <i class="ti ti-calendar"></i>
          <input type="date" name="borrow_date" id="borrow_date" class="input-control" value="{{ old('borrow_date', now()->format('Y-m-d')) }}" min="{{ now()->format('Y-m-d') }}" required>
        </div>
      </div>

      {{-- Tanggal Kembali --}}
      <div class="form-group">
        <label class="form-label">Tanggal Kembali <span>*</span></label>
        <div class="input-wrapper">
          <i class="ti ti-calendar"></i>
          <input type="date" name="return_date" id="return_date" class="input-control" value="{{ old('return_date', now()->addDay()->format('Y-m-d')) }}" required>
        </div>
      </div>

      {{-- Buttons --}}
      <div class="btn-row">
        <a href="{{ route('user.laptops.index') }}" class="btn-back">Kembali</a>
        <button type="submit" class="btn-submit">Ajukan Peminjaman</button>
      </div>

    </form>

    {{-- Info Box Abu --}}
    <div class="info-box-gray">
      <i class="ti ti-info-circle"></i>
      <div>Peminjaman Anda akan dikonfirmasi oleh admin terlebih dahulu. Mohon tunggu status persetujuan di riwayat peminjaman Anda.</div>
    </div>

  </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const borrowInput = document.getElementById('borrow_date');
  const returnInput = document.getElementById('return_date');

  function updateReturnMin() {
    const borrowVal = borrowInput.value;
    if (borrowVal) {
      // Hitung borrow_date + 1 hari
      const borrowDateObj = new Date(borrowVal);
      borrowDateObj.setDate(borrowDateObj.getDate() + 1);
      
      const year = borrowDateObj.getFullYear();
      const month = String(borrowDateObj.getMonth() + 1).padStart(2, '0');
      const day = String(borrowDateObj.getDate()).padStart(2, '0');
      
      const minReturnVal = `${year}-${month}-${day}`;
      returnInput.min = minReturnVal;
      
      // Jika return_date saat ini kurang dari minReturnVal, sesuaikan
      if (returnInput.value && returnInput.value < minReturnVal) {
        returnInput.value = minReturnVal;
      }
    }
  }

  // Set min on load
  updateReturnMin();

  // Update min on change
  borrowInput.addEventListener('change', updateReturnMin);

  // Form submit loading
  const form = document.getElementById('borrow-form');
  form.addEventListener('submit', function() {
    const btn = form.querySelector('.btn-submit');
    if (btn) {
      btn.innerHTML = '<i class="ti ti-loader animate-spin"></i> Memproses...';
      btn.disabled = true;
      btn.style.opacity = '0.8';
    }
  });
});
</script>
@endpush
@endsection
