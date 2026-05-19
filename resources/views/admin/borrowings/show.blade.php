@extends('layouts.admin')

@section('title', 'Detail Peminjaman #' . $borrowing->id)
@section('page_title', 'Detail Transaksi Peminjaman')
@section('breadcrumb')
  <a href="{{ route('admin.borrowings.index') }}">Peminjaman</a>
  <span>/</span>
  <span style="color:#64748b">Detail #{{ $borrowing->id }}</span>
@endsection

@section('content')
<style>
/* ─── DETAIL VIEW LAYOUT ───────────────────────────────────── */
.detail-container {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
  max-width: 1200px;
  margin: 0 auto;
  padding-bottom: 40px;
}
@media(min-width: 1024px) {
  .detail-container {
    grid-template-columns: 2fr 1fr; /* 2/3 + 1/3 Layout */
  }
}

/* Card General */
.premium-card {
  background: #ffffff;
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
  overflow: hidden;
}

/* Left Card Elements */
.left-card-header {
  padding: 24px;
  background: #f9fafb;
  border-bottom: 1px solid #f3f4f6;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
}
.left-card-title {
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--navy);
  margin: 0;
}
.left-card-body {
  padding: 32px 24px;
}

/* Grid Details */
.info-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 24px;
}
@media(min-width: 640px) {
  .info-grid {
    grid-template-columns: 1fr 1fr; /* Grid 2 Kolom */
  }
}

.info-item {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.info-label {
  font-size: 0.72rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
}
.info-value {
  font-size: 0.88rem;
  color: var(--text);
}

/* Specific styling for fields */
.borrower-flex {
  display: flex;
  align-items: center;
  gap: 12px;
}
.borrower-avatar-large {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: rgba(13, 159, 122, 0.1);
  color: #0D9F7A;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.95rem;
  border: 1px solid rgba(13, 159, 122, 0.2);
}
.borrower-name-bold {
  font-weight: 700;
  color: var(--text);
  font-size: 0.95rem;
}

.laptop-flex {
  display: flex;
  align-items: center;
  gap: 12px;
}
.laptop-icon-box {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  border: 1px solid #e5e7eb;
  background: #f9fafb;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #0D9F7A;
  font-size: 1.25rem;
}

/* Date transition */
.date-flow-container {
  display: flex;
  align-items: center;
  gap: 12px;
  background: #f9fafb;
  padding: 10px 14px;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  width: fit-content;
}
.date-flow-box {
  display: flex;
  flex-direction: column;
}
.date-flow-arrow {
  color: #0D9F7A;
  font-size: 1.25rem;
  display: flex;
  align-items: center;
}

/* Admin notes block */
.admin-notes-block {
  margin-top: 28px;
  padding: 16px 20px;
  background: #f8fafc;
  border-left: 4px solid #cbd5e1;
  border-radius: 0 8px 8px 0;
}
.admin-notes-text {
  font-size: 0.85rem;
  font-style: italic;
  color: #64748b;
  line-height: 1.5;
}

/* Right Panel Elements */
.right-panel-body {
  padding: 24px;
}
.right-panel-title {
  font-size: 0.95rem;
  font-weight: 700;
  color: var(--navy);
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 8px;
  border-bottom: 1px solid #f3f4f6;
  padding-bottom: 12px;
}
.right-panel-title i {
  color: #0D9F7A;
}

/* Full Width Action Buttons */
.btn-full {
  width: 100%;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 12px 20px;
  font-weight: 600;
  font-size: 0.85rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  border: none;
  transition: all 0.2s ease;
  margin-bottom: 12px;
  text-decoration: none;
}
.btn-full-teal {
  background: #0D9F7A;
  color: #ffffff !important;
  box-shadow: 0 4px 10px rgba(13, 159, 122, 0.15);
}
.btn-full-teal:hover {
  background: #0b8a6a;
  transform: translateY(-1px);
  box-shadow: 0 6px 14px rgba(13, 159, 122, 0.25);
}
.btn-full-red {
  background: #ef4444;
  color: #ffffff !important;
  box-shadow: 0 4px 10px rgba(239, 68, 68, 0.15);
}
.btn-full-red:hover {
  background: #dc2626;
  transform: translateY(-1px);
  box-shadow: 0 6px 14px rgba(239, 68, 68, 0.25);
}
.btn-full-green {
  background: #10b981;
  color: #ffffff !important;
  box-shadow: 0 4px 10px rgba(16, 185, 129, 0.15);
}
.btn-full-green:hover {
  background: #059669;
  transform: translateY(-1px);
  box-shadow: 0 6px 14px rgba(16, 185, 129, 0.25);
}

/* Rejection card container */
.rejection-panel {
  margin-top: 16px;
  padding: 16px;
  border: 1px solid #fee2e2;
  background: #fff5f5;
  border-radius: 8px;
  animation: fadeIn 0.25s ease-out;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(4px); }
  to { opacity: 1; transform: translateY(0); }
}

.textarea-reject {
  width: 100%;
  background: #ffffff;
  border: 1px solid #fecaca;
  border-radius: 0.5rem;
  padding: 10px 12px;
  font-family: 'Inter', sans-serif;
  font-size: 0.82rem;
  resize: none;
  height: 80px;
  outline: none;
  margin-bottom: 12px;
  color: var(--text);
}
.textarea-reject:focus {
  border-color: #ef4444;
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Nested Laptop Info Sub-card */
.sub-laptop-card {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 16px;
  margin-top: 24px;
}
.sub-laptop-title {
  font-size: 0.75rem;
  font-weight: 700;
  color: var(--muted);
  text-transform: uppercase;
  margin-bottom: 10px;
  letter-spacing: 0.05em;
}
.sub-laptop-row {
  display: flex;
  align-items: center;
  gap: 12px;
}
.sub-laptop-icon {
  width: 36px;
  height: 36px;
  border-radius: 6px;
  background: #fff;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #0D9F7A;
  font-size: 1.1rem;
}

/* Status Badges */
.badge-large {
  font-size: 0.75rem;
  padding: 4px 12px;
}
.status-pill-pending { background: #e5e7eb; color: #4b5563; }
.status-pill-approved { background: rgba(59,130,246,0.1); color: #1d4ed8; }
.status-pill-borrowed { background: rgba(13,159,122,0.1); color: #0D9F7A; }
.status-pill-returned { background: rgba(16,185,129,0.1); color: #047857; }
.status-pill-rejected { background: rgba(239,68,68,0.1); color: #b91c1c; }

.laptop-badge-tersedia { background: rgba(13,159,122,0.1); color: #0D9F7A; }
.laptop-badge-dipinjam { background: rgba(59,130,246,0.1); color: #1d4ed8; }
.laptop-badge-rusak { background: rgba(239,68,68,0.1); color: #b91c1c; }
.laptop-badge-maintenance { background: rgba(245,158,11,0.1); color: #92400e; }
</style>

<div class="detail-container">
  
  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  KOLOM KIRI — CARD DETAIL (2/3 Width)                       --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div class="premium-card">
    
    {{-- Header Card --}}
    <div class="left-card-header">
      <h2 class="left-card-title">Peminjaman #{{ $borrowing->id }}</h2>
      
      {{-- Badge Status Besar --}}
      @if($borrowing->status === 'pending')
        <span class="badge badge-large status-pill-pending">Pending Approval</span>
      @elseif($borrowing->status === 'approved')
        <span class="badge badge-large status-pill-approved">Approved</span>
      @elseif($borrowing->status === 'borrowed')
        <span class="badge badge-large status-pill-borrowed">Borrowed</span>
      @elseif($borrowing->status === 'returned')
        <span class="badge badge-large status-pill-returned">Returned</span>
      @elseif($borrowing->status === 'rejected')
        <span class="badge badge-large status-pill-rejected">Rejected</span>
      @else
        <span class="badge badge-large status-pill-pending">{{ ucfirst($borrowing->status) }}</span>
      @endif
    </div>

    {{-- Body Card --}}
    <div class="left-card-body">
      <div class="info-grid">
        
        {{-- Nama Peminjam --}}
        <div class="info-item">
          <span class="info-label">Nama Peminjam</span>
          <div class="borrower-flex">
            <div class="borrower-avatar-large">
              {{ strtoupper(substr($borrowing->borrower_name ?? 'U', 0, 2)) }}
            </div>
            <div>
              <span class="borrower-name-bold">{{ $borrowing->borrower_name ?? 'N/A' }}</span>
              <div style="font-size: 0.75rem; color: var(--muted); margin-top: 2px;">
                {{ $borrowing->user ? ($borrowing->user->kelas ?? 'Mahasiswa') : 'Peminjam Umum' }}
              </div>
            </div>
          </div>
        </div>

        {{-- Laptop --}}
        <div class="info-item">
          <span class="info-label">Laptop Unit</span>
          @if($borrowing->laptop)
            <div class="laptop-flex">
              <div class="sub-laptop-icon">
                <i class="ti ti-device-laptop"></i>
              </div>
              <div>
                <div style="font-weight: 700; color: var(--text);">{{ $borrowing->laptop->brand }}</div>
                <div style="font-size: 0.78rem; color: var(--muted); margin-top: 1px; display: flex; align-items: center; gap: 6px;">
                  {{ $borrowing->laptop->model }}
                  
                  {{-- Badge Status Laptop --}}
                  @if($borrowing->laptop->status === 'tersedia')
                    <span class="badge laptop-badge-tersedia" style="font-size: 0.6rem; padding: 1px 6px;">Tersedia</span>
                  @elseif($borrowing->laptop->status === 'dipinjam')
                    <span class="badge laptop-badge-dipinjam" style="font-size: 0.6rem; padding: 1px 6px;">Dipinjam</span>
                  @elseif($borrowing->laptop->status === 'rusak')
                    <span class="badge laptop-badge-rusak" style="font-size: 0.6rem; padding: 1px 6px;">Rusak</span>
                  @elseif($borrowing->laptop->status === 'maintenance')
                    <span class="badge laptop-badge-maintenance" style="font-size: 0.6rem; padding: 1px 6px;">Maintenance</span>
                  @else
                    <span class="badge laptop-badge-tersedia" style="font-size: 0.6rem; padding: 1px 6px;">{{ ucfirst($borrowing->laptop->status) }}</span>
                  @endif
                </div>
              </div>
            </div>
          @else
            <span class="info-value text-red-500">Laptop data deleted</span>
          @endif
        </div>

        {{-- Keperluan --}}
        <div class="info-item" style="grid-column: 1 / -1;">
          <span class="info-label">Keperluan Peminjaman</span>
          <div class="info-value" style="font-weight: 500; font-size: 0.92rem; color: var(--text);">
            {{ $borrowing->purpose }}
          </div>
        </div>

        {{-- Tanggal Pinjam -> Kembali --}}
        <div class="info-item" style="grid-column: 1 / -1;">
          <span class="info-label">Jangka Waktu Peminjaman</span>
          <div class="date-flow-container">
            <div class="date-flow-box">
              <span style="font-size: 0.65rem; color: var(--muted); font-weight:600; text-transform:uppercase;">Tanggal Pinjam</span>
              <span style="font-weight: 700; color: var(--text); font-size: 0.88rem;">
                {{ $borrowing->borrow_date->format('d M Y') }}
              </span>
            </div>
            
            <div class="date-flow-arrow">
              <i class="ti ti-arrow-narrow-right"></i>
            </div>
            
            <div class="date-flow-box">
              <span style="font-size: 0.65rem; color: var(--muted); font-weight:600; text-transform:uppercase;">Tanggal Kembali</span>
              <span style="font-weight: 700; color: @if($borrowing->isLate()) var(--red) @else var(--text) @endif; font-size: 0.88rem; display: flex; align-items: center; gap: 4px;">
                {{ $borrowing->return_date->format('d M Y') }}
                @if($borrowing->isLate())
                  <i class="ti ti-alert-triangle" style="font-size: 1rem; color: var(--red);" title="Terlambat!"></i>
                @endif
              </span>
            </div>
          </div>
        </div>

      </div>

      {{-- Catatan Admin (jika ada) --}}
      @if($borrowing->admin_note)
        <div class="admin-notes-block">
          <span class="info-label" style="display:block; margin-bottom:4px;">Catatan Admin</span>
          <p class="admin-notes-text">"{{ $borrowing->admin_note }}"</p>
        </div>
      @endif

    </div>
  </div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  KOLOM KANAN — CARD AKSI (1/3 Width)                        --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div>
    <div class="premium-card">
      <div class="right-panel-body">
        
        <h3 class="right-panel-title">
          <i class="ti ti-adjustments-horizontal"></i> Panel Aksi
        </h3>

        {{-- Jika status = pending --}}
        @if($borrowing->status === 'pending')
          
          {{-- Tombol Setujui Peminjaman --}}
          <form method="POST" action="{{ route('admin.borrowings.approve', $borrowing->id) }}" style="margin-bottom: 12px;">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn-full btn-full-teal">
              <i class="ti ti-circle-check"></i> Setujui Peminjaman
            </button>
          </form>

          {{-- Tombol Tolak (Toggles text area) --}}
          <button type="button" class="btn-full btn-full-red" id="btnShowRejectPanel" onclick="toggleRejectPanel()">
            <i class="ti ti-circle-x"></i> Tolak Peminjaman
          </button>

          {{-- Form Tolak + Textarea Alasan --}}
          <div class="rejection-panel" id="rejectionPanel" style="display: none;">
            <form method="POST" action="{{ route('admin.borrowings.reject', $borrowing->id) }}">
              @csrf
              @method('PATCH')
              <label class="info-label" for="admin_note" style="display:block; margin-bottom: 6px; color: var(--red);">Alasan Penolakan*</label>
              <textarea id="admin_note" 
                        name="admin_note" 
                        class="textarea-reject" 
                        placeholder="Misal: Stok laptop unit ini sedang maintenance..." 
                        required></textarea>
              
              <div style="display: flex; gap: 8px;">
                <button type="button" class="btn-cancel" style="flex:1; padding: 8px 12px; font-size: 0.78rem;" onclick="toggleRejectPanel()">Batal</button>
                <button type="submit" class="btn-save" style="flex:1.5; padding: 8px 12px; font-size: 0.78rem; background: var(--red); box-shadow:none;">Kirim Penolakan</button>
              </div>
            </form>
          </div>

        {{-- Jika status = borrowed --}}
        @elseif($borrowing->status === 'borrowed')
          
          {{-- Tombol Tandai Dikembalikan --}}
          <form method="POST" action="{{ route('admin.returns.store') }}">
            @csrf
            <input type="hidden" name="borrowing_id" value="{{ $borrowing->id }}">
            <input type="hidden" name="condition_after" value="baik">
            <button type="submit" class="btn-full btn-full-green">
              <i class="ti ti-clipboard-check"></i> Tandai Dikembalikan
            </button>
          </form>

        @else
          {{-- Status else (approved, returned, rejected) --}}
          <div style="text-align: center; padding: 20px 10px; color: var(--muted); font-size: 0.82rem;">
            <i class="ti ti-lock" style="font-size: 2rem; display:block; margin-bottom: 8px; opacity:0.5;"></i>
            Transaksi ini telah selesai/dikunci dan tidak memerlukan tindakan admin lebih lanjut.
          </div>
        @endif

        {{-- Nested Laptop Info Sub-card --}}
        @if($borrowing->laptop)
          <div class="sub-laptop-card">
            <div class="sub-laptop-title">Detail Perangkat</div>
            <div class="sub-laptop-row">
              <div class="sub-laptop-icon">
                <i class="ti ti-device-laptop"></i>
              </div>
              <div style="min-width: 0; flex: 1;">
                <div style="font-weight: 700; font-size: 0.8rem; color: var(--text); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                  {{ $borrowing->laptop->brand }}
                </div>
                <div style="font-size: 0.72rem; color: var(--muted); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 1px;">
                  {{ $borrowing->laptop->model }}
                </div>
              </div>
              <div style="flex-shrink: 0;">
                @if($borrowing->laptop->status === 'tersedia')
                  <span class="badge laptop-badge-tersedia" style="font-size: 0.6rem; padding: 2px 8px;">Tersedia</span>
                @else
                  <span class="badge laptop-badge-dipinjam" style="font-size: 0.6rem; padding: 2px 8px;">Dipinjam</span>
                @endif
              </div>
            </div>
          </div>
        @endif

      </div>
    </div>
  </div>

</div>

@push('scripts')
<script>
function toggleRejectPanel() {
  var panel = document.getElementById('rejectionPanel');
  var btn = document.getElementById('btnShowRejectPanel');
  if (panel.style.display === 'none') {
    panel.style.display = 'block';
    btn.style.display = 'none';
    document.getElementById('admin_note').focus();
  } else {
    panel.style.display = 'none';
    btn.style.display = 'block';
  }
}
</script>
@endpush
@endsection
