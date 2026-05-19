@extends('layouts.app')

@section('title', $laptop->brand . ' ' . $laptop->model)

@section('content')
<style>
/* ─── PREMIUM LAPTOP DETAIL STYLES ────────────────────────── */
.detail-container {
  max-width: 1200px;
  margin: 104px auto 40px;
  padding: 0 24px;
}

/* Back navigation */
.back-nav {
  margin-bottom: 20px;
  display: flex;
  align-items: center;
}
.back-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  color: var(--muted);
  text-decoration: none;
  font-size: .82rem;
  font-weight: 600;
  transition: color .2s;
}
.back-link:hover {
  color: var(--teal);
}

/* Two Column Layout */
.detail-layout {
  display: grid;
  grid-template-columns: 3.2fr 2.8fr;
  gap: 32px;
  align-items: start;
}
@media(max-width: 991px) {
  .detail-layout {
    grid-template-columns: 1fr;
  }
}

/* Left Column */
.left-col {
  display: flex;
  flex-direction: column;
  gap: 24px;
}
.photo-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 24px;
  position: relative;
}
.big-img-box {
  width: 100%;
  height: 320px;
  background: #f8fafc;
  border-radius: 12px;
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 5rem;
  color: var(--teal);
  overflow: hidden;
}
.big-img-box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.detail-identity {
  margin-top: 20px;
}
.identity-brand {
  font-size: .8rem;
  font-weight: 700;
  text-transform: uppercase;
  color: var(--muted);
  letter-spacing: .05em;
}
.identity-name {
  font-size: 1.4rem;
  font-weight: 700;
  color: var(--text);
  margin: 4px 0 10px;
  line-height: 1.2;
}
.identity-cat {
  display: inline-block;
  font-size: .72rem;
  font-weight: 700;
  color: var(--teal);
  background: var(--teal-dim);
  padding: 4px 12px;
  border-radius: 6px;
}

.large-badge-pos {
  position: absolute;
  top: 36px;
  right: 36px;
  z-index: 5;
}
.large-badge {
  font-size: .75rem;
  font-weight: 700;
  padding: 6px 14px;
  border-radius: 999px;
  box-shadow: 0 4px 10px rgba(0,0,0,.05);
}

/* Right Column Cards */
.right-col {
  display: flex;
  flex-direction: column;
  gap: 24px;
}
.spec-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 24px;
}
.card-title {
  font-size: .85rem;
  font-weight: 700;
  color: var(--text);
  text-transform: uppercase;
  letter-spacing: .05em;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  gap: 8px;
}

.spec-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
@media(max-width: 480px) {
  .spec-grid {
    grid-template-columns: 1fr;
  }
}
.spec-item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
}
.spec-icon {
  width: 28px;
  height: 28px;
  border-radius: 6px;
  background: var(--teal-dim);
  color: var(--teal);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .95rem;
  flex-shrink: 0;
}
.spec-lbl {
  font-size: .68rem;
  color: var(--muted);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: .02em;
}
.spec-val {
  font-size: .8rem;
  font-weight: 700;
  color: var(--text);
  margin-top: 2px;
  word-break: break-word;
}

/* Borrowing Action Card */
.action-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.02);
  padding: 24px;
}

/* Custom form elements */
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

.warning-card {
  background: rgba(59, 130, 246, 0.04);
  border: 1px solid rgba(59, 130, 246, 0.15);
  border-radius: 10px;
  padding: 16px;
  color: #1e3a8a;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-size: .8rem;
  line-height: 1.4;
}
.warning-card i {
  font-size: 1.2rem;
  color: #3b82f6;
}
</style>

<div class="detail-container">
  
  {{-- Back Navigation --}}
  <div class="back-nav">
    <a href="{{ route('user.laptops.index') }}" class="back-link">
      <i class="ti ti-arrow-left"></i> Kembali ke Katalog
    </a>
  </div>

  <div class="detail-layout">
    
    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{--  KOLOM KIRI (3/5)                                          --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="left-col">
      
      {{-- Photo & Title Card --}}
      <article class="photo-card">
        
        {{-- Absolute Badge --}}
        <div class="large-badge-pos">
          @if($laptop->status === 'tersedia')
            <span class="badge large-badge badge-teal">Tersedia</span>
          @elseif($laptop->status === 'dipinjam')
            <span class="badge large-badge badge-blue">Sedang Dipinjam</span>
          @elseif($laptop->status === 'maintenance')
            <span class="badge large-badge badge-amber">Dalam Perbaikan</span>
          @else
            <span class="badge large-badge badge-red">Rusak</span>
          @endif
        </div>

        {{-- Big Image --}}
        <div class="big-img-box">
          @if($laptop->image)
            <img src="{{ asset('storage/' . $laptop->image) }}" alt="Laptop model photo">
          @else
            <i class="ti ti-device-laptop"></i>
          @endif
        </div>

        {{-- Brand & Model Info --}}
        <div class="detail-identity">
          <div class="identity-brand">{{ $laptop->brand }}</div>
          <h1 class="identity-name">{{ $laptop->model }}</h1>
          
          @if($laptop->category)
            <div class="identity-cat">
              <i class="ti ti-tag"></i> {{ $laptop->category->name }}
            </div>
          @endif
        </div>

      </article>

    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{--  KOLOM KANAN (2/5)                                         --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="right-col">
      
      {{-- Card Spesifikasi Lengkap --}}
      <section class="spec-card">
        <h3 class="card-title"><i class="ti ti-cpu" style="color:var(--teal)"></i> Spesifikasi Unit</h3>
        
        <div class="spec-grid">
          
          {{-- Kode Laptop --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-barcode"></i></div>
            <div>
              <div class="spec-lbl">Kode Unit</div>
              <div class="spec-val" style="font-family: monospace;">{{ $laptop->code }}</div>
            </div>
          </div>

          {{-- Serial Number --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-hash"></i></div>
            <div>
              <div class="spec-lbl">Serial Number</div>
              <div class="spec-val">{{ $laptop->serial_number ?? '-' }}</div>
            </div>
          </div>

          {{-- Prosesor --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-cpu"></i></div>
            <div>
              <div class="spec-lbl">Prosesor</div>
              <div class="spec-val">{{ $laptop->processor ?? '-' }}</div>
            </div>
          </div>

          {{-- RAM --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-database"></i></div>
            <div>
              <div class="spec-lbl">Memori RAM</div>
              <div class="spec-val">{{ $laptop->ram ?? '8' }} GB</div>
            </div>
          </div>

          {{-- Storage --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-server"></i></div>
            <div>
              <div class="spec-lbl">Penyimpanan</div>
              <div class="spec-val">{{ $laptop->storage ?? '-' }} SSD</div>
            </div>
          </div>

          {{-- VGA --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-device-gamepad-2"></i></div>
            <div>
              <div class="spec-lbl">Kartu Grafis (VGA)</div>
              <div class="spec-val">{{ $laptop->vga ?? 'Integrated Intel Graphics' }}</div>
            </div>
          </div>

          {{-- Kondisi Fisik --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-shield-check"></i></div>
            <div>
              <div class="spec-lbl">Kondisi Fisik</div>
              <div class="spec-val" style="text-transform: uppercase;">{{ str_replace('_', ' ', $laptop->condition) }}</div>
            </div>
          </div>

          {{-- Kategori --}}
          <div class="spec-item">
            <div class="spec-icon"><i class="ti ti-tag"></i></div>
            <div>
              <div class="spec-lbl">Kelompok Rumpun</div>
              <div class="spec-val">{{ $laptop->category->name ?? 'N/A' }}</div>
            </div>
          </div>

        </div>
      </section>

      {{-- ═══════════════════════════════════════════════════════════ --}}
      {{--  Card Aksi Pinjam (Tersedia) / Info Pinjam (Dipinjam)     --}}
      {{-- ═══════════════════════════════════════════════════════════ --}}
      <section class="action-card" id="borrow-section">
        
        @if($laptop->status === 'tersedia')
          <h3 class="card-title"><i class="ti ti-clipboard-list" style="color:var(--teal)"></i> Formulir Peminjaman</h3>
          
          <form method="POST" action="{{ route('user.borrowings.store') }}">
            @csrf
            <input type="hidden" name="laptop_id" value="{{ $laptop->id }}">

            {{-- Tgl Mulai Pinjam --}}
            <div class="field" style="margin-bottom: 16px;">
              <label class="f-label">Tanggal Mulai Pinjam <span>*</span></label>
              <div class="f-input-wrapper">
                <i class="ti ti-calendar-event"></i>
                <input type="date" name="borrow_date" class="f-input" value="{{ now()->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" required>
              </div>
            </div>

            {{-- Tgl Rencana Kembali --}}
            <div class="field" style="margin-bottom: 16px;">
              <label class="f-label">Tanggal Rencana Pengembalian <span>*</span></label>
              <div class="f-input-wrapper">
                <i class="ti ti-calendar-time"></i>
                <input type="date" name="return_date" class="f-input" value="{{ now()->addDays(3)->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}" required>
              </div>
            </div>

            {{-- Keperluan --}}
            <div class="field" style="margin-bottom: 18px;">
              <label class="f-label">Keperluan Peminjaman <span>*</span></label>
              <textarea name="purpose" class="f-input" style="height: 90px; padding: 10px; resize: none;" placeholder="Tuliskan alasan / keperluan meminjam unit laptop ini secara detail..." required></textarea>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
              Ajukan Peminjaman Unit
            </button>

            <p style="font-size: 0.72rem; color: var(--muted); text-align: center; margin-top: 10px; font-weight: 500;">
              * Peminjaman memerlukan persetujuan dari Admin sebelum unit diserahkan.
            </p>
          </form>

        @elseif($laptop->status === 'dipinjam')
          @php
            $activeBorrowing = $laptop->borrowings()->whereIn('status', ['approved', 'borrowed'])->latest()->first();
            $estReturnDate = $activeBorrowing ? $activeBorrowing->return_date->format('d M Y') : 'segera';
          @endphp
          <h3 class="card-title"><i class="ti ti-info-circle" style="color:#3b82f6"></i> Informasi Ketersediaan</h3>
          <div class="warning-card">
            <i class="ti ti-alert-circle"></i>
            <div>
              <span style="font-weight: 700; color: #1e3a8a;">Laptop Sedang Dipinjam</span>
              <p style="margin-top: 4px; color: #1e40af;">
                Unit ini saat ini sedang dipinjam oleh mahasiswa lain. Estimasi pengembalian unit adalah pada tanggal <strong>{{ $estReturnDate }}</strong>.
              </p>
            </div>
          </div>

        @elseif($laptop->status === 'maintenance')
          <h3 class="card-title"><i class="ti ti-info-circle" style="color:#f59e0b"></i> Informasi Ketersediaan</h3>
          <div class="warning-card" style="background: rgba(245, 158, 11, 0.04); border-color: rgba(245, 158, 11, 0.15); color: #78350f;">
            <i class="ti ti-tool" style="color: #f59e0b;"></i>
            <div>
              <span style="font-weight: 700; color: #78350f;">Sedang Dalam Perbaikan</span>
              <p style="margin-top: 4px; color: #92400e;">
                Unit laptop ini sedang berada dalam masa pemeliharaan rutin atau perbaikan teknis agar dapat digunakan kembali secara maksimal.
              </p>
            </div>
          </div>

        @else
          <h3 class="card-title"><i class="ti ti-info-circle" style="color:#ef4444"></i> Informasi Ketersediaan</h3>
          <div class="warning-card" style="background: rgba(239, 68, 68, 0.04); border-color: rgba(239, 68, 68, 0.15); color: #7f1d1d;">
            <i class="ti ti-ban" style="color: #ef4444;"></i>
            <div>
              <span style="font-weight: 700; color: #7f1d1d;">Unit Rusak</span>
              <p style="margin-top: 4px; color: #991b1b;">
                Mohon maaf, unit laptop ini mengalami kerusakan berat fisik/sistem dan sedang tidak diizinkan untuk dipinjam oleh mahasiswa.
              </p>
            </div>
          </div>
        @endif

      </section>

    </div>

  </div>

</div>

@push('scripts')
<script>
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
