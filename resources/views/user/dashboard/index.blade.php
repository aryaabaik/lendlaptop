@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
/* ─── PREMIUM USER DASHBOARD STYLES ───────────────────────── */
.dashboard-container {
  max-width: 1200px;
  margin: 104px auto 40px;
  padding: 0 24px;
}

/* 1. Welcome Banner */
.welcome-banner {
  background: linear-gradient(135deg, #0d9f7a 0%, #076b52 100%);
  border-radius: 1rem;
  padding: 32px;
  color: #fff;
  position: relative;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(13,159,122,.15);
  margin-bottom: 28px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.welcome-banner::before {
  content: '';
  position: absolute;
  right: -50px;
  top: -50px;
  width: 260px;
  height: 260px;
  background: radial-gradient(circle, rgba(255,255,255,.1) 0%, transparent 70%);
  border-radius: 50%;
  pointer-events: none;
}
.welcome-title {
  font-size: 1.6rem;
  font-weight: 700;
  margin-bottom: 8px;
  letter-spacing: -0.02em;
}
.welcome-sub {
  font-size: .88rem;
  color: rgba(255,255,255,.8);
  font-weight: 500;
}
.welcome-action {
  background: #fff;
  color: #076b52;
  font-weight: 700;
  padding: 12px 24px;
  border-radius: 10px;
  text-decoration: none;
  font-size: .85rem;
  box-shadow: 0 4px 14px rgba(0,0,0,.1);
  transition: all .2s;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  border: none;
  cursor: pointer;
}
.welcome-action:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255,255,255,.2);
  background: #f8fafc;
}
@media(max-width: 767px) {
  .welcome-banner {
    flex-direction: column;
    align-items: flex-start;
    gap: 20px;
    padding: 24px;
  }
}

/* 2. Stat Cards */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  margin-bottom: 32px;
}
@media(max-width: 767px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
}
.stat-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  transition: all .2s;
}
.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 16px rgba(10,22,40,.04);
}
.stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.3rem;
  flex-shrink: 0;
}
.stat-num {
  font-size: 1.4rem;
  font-weight: 700;
  color: var(--text);
  line-height: 1.2;
}
.stat-lbl {
  font-size: .75rem;
  color: var(--muted);
  font-weight: 600;
  margin-top: 2px;
}

/* 3. Section Title */
.sec-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 18px;
}
.sec-title {
  font-size: 1rem;
  font-weight: 700;
  color: var(--text);
  text-transform: uppercase;
  letter-spacing: .03em;
  display: flex;
  align-items: center;
  gap: 8px;
}
.sec-link {
  font-size: .8rem;
  font-weight: 600;
  color: var(--teal);
  text-decoration: none;
  transition: color .2s;
}
.sec-link:hover {
  color: var(--teal-dark);
  text-decoration: underline;
}

/* 4. Active Borrowing Cards */
.active-borrow-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
  margin-bottom: 32px;
}
.borrow-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.04);
  padding: 20px;
  display: grid;
  grid-template-columns: auto 1fr auto;
  gap: 24px;
  align-items: center;
}
@media(max-width: 767px) {
  .borrow-card {
    grid-template-columns: 1fr;
    gap: 16px;
  }
}
.borrow-laptop-info {
  display: flex;
  align-items: center;
  gap: 16px;
}
.borrow-thumb {
  width: 60px;
  height: 60px;
  border-radius: 10px;
  border: 1px solid var(--border);
  background: #f8fafc;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--teal);
  font-size: 1.5rem;
  flex-shrink: 0;
}
.borrow-thumb img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 9px;
}

.borrow-name {
  font-weight: 700;
  font-size: .95rem;
  color: var(--text);
}
.borrow-code {
  font-family: monospace;
  font-size: .75rem;
  color: var(--muted);
  margin-top: 2px;
}

.borrow-progress-box {
  width: 100%;
  max-width: 400px;
}
.progress-meta {
  display: flex;
  justify-content: space-between;
  font-size: .72rem;
  font-weight: 600;
  color: var(--muted);
  margin-bottom: 6px;
}
.progress-bar-bg {
  width: 100%;
  height: 6px;
  background: #e2e8f0;
  border-radius: 3px;
  overflow: hidden;
}
.progress-bar-fill {
  height: 100%;
  border-radius: 3px;
  transition: width .5s ease;
}

/* 5. Laptop Grid Preview */
.laptop-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 40px;
}
@media(max-width: 991px) {
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
.lap-img-container {
  width: 100%;
  height: 120px;
  background: #f8fafc;
  border-radius: 10px;
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2.5rem;
  color: var(--teal);
  overflow: hidden;
  margin-bottom: 12px;
}
.lap-img-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.lap-brand {
  font-size: .68rem;
  font-weight: 700;
  text-transform: uppercase;
  color: var(--muted);
  letter-spacing: .02em;
}
.lap-name {
  font-size: .88rem;
  font-weight: 700;
  color: var(--text);
  margin: 2px 0 6px;
}
.lap-specs {
  display: flex;
  flex-direction: column;
  gap: 4px;
  font-size: .74rem;
  color: var(--muted);
  margin-bottom: 16px;
}
.lap-spec-item {
  display: flex;
  align-items: center;
  gap: 6px;
}
.lap-spec-item i {
  font-size: .85rem;
  color: var(--teal);
}

.lap-action-row {
  margin-top: auto;
  border-top: 1px solid #f1f5f9;
  padding-top: 12px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.lap-status-pill {
  font-size: .7rem;
  font-weight: 700;
  color: var(--teal);
  background: var(--teal-dim);
  padding: 4px 10px;
  border-radius: 9999px;
}
.lap-btn-pinjam {
  padding: 6px 14px;
  font-size: .75rem;
  font-weight: 700;
  border-radius: 8px;
  background: var(--teal);
  color: #fff;
  border: none;
  cursor: pointer;
  text-decoration: none;
  transition: background .2s;
}
.lap-btn-pinjam:hover {
  background: var(--teal-dark);
}
</style>

<div class="dashboard-container">
  
  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  1. WELCOME BANNER                                         --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <section class="welcome-banner">
    <div>
      <h1 class="welcome-title">Selamat datang kembali, {{ $user->name }}! 👋</h1>
      <p class="welcome-sub">
        {{ $user->kelas ?? 'Mahasiswa' }} · Universitas Informatika dan Bisnis Indonesia
      </p>
    </div>
    <div>
      <a href="{{ route('user.laptops.index') }}" class="welcome-action">
        <i class="ti ti-device-laptop"></i> Pinjam Laptop Sekarang
      </a>
    </div>
  </section>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  2. STAT CARDS (3 Kolom)                                    --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <section class="stats-grid">
    
    {{-- Peminjaman Aktif --}}
    <div class="stat-card">
      <div class="stat-icon" style="background: var(--teal-dim); color: var(--teal);">
        <i class="ti ti-device-laptop"></i>
      </div>
      <div>
        <div class="stat-num">{{ $stats['active'] }}</div>
        <div class="stat-lbl">Peminjaman Aktif</div>
      </div>
    </div>

    {{-- Menunggu Persetujuan --}}
    <div class="stat-card">
      <div class="stat-icon" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b;">
        <i class="ti ti-clock animate-pulse"></i>
      </div>
      <div>
        <div class="stat-num">{{ $stats['pending'] }}</div>
        <div class="stat-lbl">Menunggu Persetujuan</div>
      </div>
    </div>

    {{-- Total Riwayat --}}
    <div class="stat-card">
      <div class="stat-icon" style="background: rgba(59, 130, 246, 0.08); color: #3b82f6;">
        <i class="ti ti-history"></i>
      </div>
      <div>
        <div class="stat-num">{{ $stats['returned'] }}</div>
        <div class="stat-lbl">Total Riwayat Pengembalian</div>
      </div>
    </div>

  </section>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  3. PEMINJAMAN AKTIF                                       --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <section class="sec-header">
    <h2 class="sec-title"><i class="ti ti-device-laptop" style="color:var(--teal)"></i> Laptop Yang Sedang Dipinjam</h2>
    <a href="{{ route('user.borrowings.index') }}" class="sec-link">Lihat Riwayat & Status Peminjaman →</a>
  </section>

  <section class="active-borrow-grid">
    @if($activeBorrowings->isEmpty())
      <div style="background: #fff; border-radius: 1rem; border: 1px solid #f1f5f9; padding: 40px; text-align: center; color: var(--muted);">
        <i class="ti ti-circle-check" style="font-size: 2.8rem; color: var(--teal); margin-bottom: 12px; display: block;"></i>
        Anda tidak memiliki peminjaman aktif saat ini.
        <a href="{{ route('user.laptops.index') }}" style="display:inline-block; margin-top:8px; color:var(--teal); font-weight:700; text-decoration:none;">
          Telusuri Unit Tersedia →
        </a>
      </div>
    @else
      @foreach($activeBorrowings as $b)
        @php
          $totalDays = $b->borrow_date->diffInDays($b->return_date) ?: 1;
          $elapsedDays = $b->borrow_date->diffInDays(now()) ?: 0;
          $pct = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));
          $barColor = $pct > 80 ? 'var(--red)' : ($pct > 50 ? 'var(--amber)' : 'var(--teal)');
        @endphp
        <div class="borrow-card">
          
          {{-- Laptop Info --}}
          <div class="borrow-laptop-info">
            <div class="borrow-thumb">
              @if($b->laptop && $b->laptop->image)
                <img src="{{ asset('storage/' . $b->laptop->image) }}" alt="Laptop thumbnail">
              @else
                <i class="ti ti-device-laptop"></i>
              @endif
            </div>
            <div>
              <div class="borrow-name">{{ $b->laptop->brand ?? 'N/A' }} {{ $b->laptop->model ?? '' }}</div>
              <div class="borrow-code">Kode Unit: {{ $b->laptop->code ?? 'N/A' }}</div>
            </div>
          </div>

          {{-- Progress Bar --}}
          <div class="borrow-progress-box">
            <div class="progress-meta">
              <span>{{ $b->borrow_date->format('d M Y') }} → {{ $b->return_date->format('d M Y') }}</span>
              <span>{{ $pct }}% Waktu Berlalu</span>
            </div>
            <div class="progress-bar-bg">
              <div class="progress-bar-fill" style="width: {{ $pct }}%; background: {{ $barColor }};"></div>
            </div>
          </div>

          {{-- Action --}}
          <div style="display:flex; align-items:center; gap:12px;">
            @if($b->status === 'approved')
              <span class="badge badge-teal">Disetujui</span>
            @else
              <span class="badge badge-blue">Sedang Dipinjam</span>
            @endif

            <a href="{{ route('user.borrowings.show', $b->id) }}" class="btn btn-secondary" style="padding: 8px 16px; font-size: 0.78rem;">
              Lihat Detail
            </a>
          </div>

        </div>
      @endforeach
    @endif
  </section>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  4. LAPTOP TERSEDIA (Preview 4 Cards)                      --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <section class="sec-header">
    <h2 class="sec-title"><i class="ti ti-grid-dots" style="color:var(--teal)"></i> Laptop Tersedia Untuk Dipinjam</h2>
    <a href="{{ route('user.laptops.index') }}" class="sec-link">Lihat Semua Laptop →</a>
  </section>

  <section class="laptop-grid">
    @if($availableLaptops->isEmpty())
      <div style="grid-column: 1 / -1; background: #fff; border-radius: 1rem; border: 1px solid #f1f5f9; padding: 40px; text-align: center; color: var(--muted);">
        <i class="ti ti-alert-circle" style="font-size: 2.8rem; color: var(--amber); margin-bottom: 12px; display: block;"></i>
        Mohon maaf, semua unit laptop sedang dipinjam saat ini. Silakan hubungi admin.
      </div>
    @else
      @foreach($availableLaptops as $lap)
        <div class="lap-card">
          
          {{-- Image --}}
          <div class="lap-img-container">
            @if($lap->image)
              <img src="{{ asset('storage/' . $lap->image) }}" alt="Laptop thumbnail">
            @else
              <i class="ti ti-device-laptop"></i>
            @endif
          </div>

          {{-- Identity --}}
          <div class="lap-brand">{{ $lap->brand }}</div>
          <h3 class="lap-name">{{ $lap->model }}</h3>

          {{-- Specs --}}
          <div class="lap-specs">
            <div class="lap-spec-item">
              <i class="ti ti-cpu"></i>
              <span>{{ Str::limit($lap->processor ?? 'Processor standard', 22) }}</span>
            </div>
            <div class="lap-spec-item">
              <i class="ti ti-database"></i>
              <span>RAM {{ $lap->ram ?? '8' }}GB / {{ $lap->storage ?? '256GB' }}</span>
            </div>
          </div>

          {{-- Action Row --}}
          <div class="lap-action-row">
            <span class="lap-status-pill">Tersedia</span>
            <a href="{{ route('user.laptops.show', $lap->id) }}" class="lap-btn-pinjam">
              Pinjam
            </a>
          </div>

        </div>
      @endforeach
    @endif
  </section>

</div>
@endsection
