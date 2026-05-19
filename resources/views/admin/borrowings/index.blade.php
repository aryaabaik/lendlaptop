@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')
@section('page_title', 'Manajemen Peminjaman')
@section('breadcrumb')
  <span>Peminjaman</span>
@endsection

@section('content')
<style>
/* ─── PREMIUM ADMIN BORROWINGS STYLING ────────────────────── */
.borrow-header-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  gap: 16px;
}
.borrow-title {
  font-size: 1.25rem;
  font-weight: 700;
  color: var(--navy);
}
.btn-primary-themed {
  background: #0D9F7A; /* Warna utama (teal) */
  color: #fff !important;
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 20px;
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  border: none;
  transition: all 0.2s ease;
  box-shadow: 0 4px 10px rgba(13,159,122,0.15);
  font-size: 0.85rem;
  cursor: pointer;
}
.btn-primary-themed:hover {
  background: #0b8a6a; /* hover:bg-[#0b8a6a] */
  transform: translateY(-1px);
  box-shadow: 0 6px 14px rgba(13,159,122,0.25);
}

/* Filter Card Styling */
.filter-card {
  background: #fff; /* bg-white */
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  padding: 24px;
  margin-bottom: 20px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.filter-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 16px;
  align-items: flex-end;
}
@media(max-width: 1199px) {
  .filter-grid {
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  }
}
.f-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}
.f-label {
  font-size: 0.75rem;
  font-weight: 600;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.05em;
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
  background: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 9.5px 14px 9.5px 40px; /* padding & space for left icon */
  font-family: 'Inter', sans-serif;
  font-size: 0.82rem;
  color: var(--text);
  outline: none;
  transition: all 0.2s ease;
}
.f-input:focus {
  border-color: #0D9F7A;
  background: #fff;
}
.f-select {
  padding-right: 28px;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 14px;
}
.filter-actions {
  display: flex;
  gap: 8px;
}
.btn-filter-submit {
  background: #0D9F7A;
  color: #fff;
  border: none;
  border-radius: 0.5rem;
  padding: 10px 18px;
  font-weight: 600;
  font-size: 0.82rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: background-color 0.15s;
}
.btn-filter-submit:hover {
  background: #0b8a6a;
}
.btn-filter-reset {
  background: #fff;
  color: var(--text);
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  padding: 10px 18px;
  font-weight: 600;
  font-size: 0.82rem;
  cursor: pointer;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.15s;
}
.btn-filter-reset:hover {
  background: #f9fafb;
  border-color: #cbd5e1;
}

/* Info Pills Below Filter */
.pills-bar {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 24px;
}
.pill-day-link {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 9999px;
  padding: 6px 14px;
  font-size: 0.78rem;
  color: var(--muted);
  font-weight: 500;
  text-decoration: none;
  transition: all 0.2s ease;
}
.pill-day-link:hover {
  background: #f3f4f6;
  color: var(--text);
  transform: translateY(-1px);
}
.pill-day-link.active {
  background: #0D9F7A; /* Warna aktif teal */
  border-color: #0D9F7A;
  color: #fff !important;
  font-weight: 600;
  box-shadow: 0 4px 8px rgba(13,159,122,0.2);
}
.pill-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: #0D9F7A;
}
.pill-day-link.active .pill-dot {
  background: #fff;
}

/* Table Card responsive */
.tbl-card {
  background: #fff;
  border-radius: 0.75rem; /* rounded-xl */
  border: 1px solid #f3f4f6; /* border-gray-100 */
  box-shadow: 0 1px 3px rgba(0,0,0,0.02);
  overflow: hidden;
  margin-bottom: 24px;
}
.tbl-responsive {
  width: 100%;
  overflow-x: auto;
}
.tbl-custom {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 0.82rem;
}
.tbl-custom th {
  padding: 14px 18px;
  background: #f9fafb;
  color: var(--muted);
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.7rem;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #f3f4f6;
}
.tbl-custom td {
  padding: 14px 18px;
  border-bottom: 1px solid #f9fafb;
  color: var(--text);
  vertical-align: middle;
}
.tbl-custom tr:last-child td {
  border-bottom: none;
}

/* Baris terlambat (row bg-red-50) */
.tbl-custom tr.row-late {
  background-color: #fef2f2 !important; /* bg-red-50 */
  border-left: 4px solid #ef4444; /* border-red-500 */
  transition: background-color 0.2s;
}
.tbl-custom tr.row-late td {
  border-bottom-color: #fee2e2;
}

/* Cells formatting */
.borrower-info {
  display: flex;
  align-items: center;
  gap: 10px;
}
.borrower-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: rgba(13,159,122,0.1);
  color: #0D9F7A;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.75rem;
}
.laptop-info {
  display: flex;
  align-items: center;
  gap: 10px;
}
.laptop-icon-box {
  width: 38px;
  height: 38px;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
  background: #f9fafb;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #0D9F7A;
  font-size: 1.1rem;
}
.laptop-icon-box img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 7px;
}

/* Action button configurations */
.btn-group-action {
  display: flex;
  align-items: center;
  gap: 6px;
}
.btn-act {
  padding: 6px 12px;
  font-size: 0.75rem;
  font-weight: 600;
  border-radius: 6px;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  border: none;
  text-decoration: none;
  transition: all 0.15s ease;
}
.btn-act-approve {
  background: rgba(13,159,122,0.1);
  color: #0D9F7A;
}
.btn-act-approve:hover {
  background: #0D9F7A;
  color: #fff;
  box-shadow: 0 4px 8px rgba(13,159,122,0.2);
}
.btn-act-reject {
  background: rgba(239,68,68,0.08);
  color: var(--red);
}
.btn-act-reject:hover {
  background: var(--red);
  color: #fff;
  box-shadow: 0 4px 8px rgba(239,68,68,0.2);
}
.btn-act-detail {
  background: #f1f5f9;
  color: var(--muted);
}
.btn-act-detail:hover {
  background: #cbd5e1;
  color: var(--text);
}

/* Status Badges */
.status-pill {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 10px;
  border-radius: 9999px;
  font-size: 0.7rem;
  font-weight: 600;
  line-height: 1.5;
}
.status-pill-pending { background: #e5e7eb; color: #4b5563; } /* pending=gray */
.status-pill-approved { background: rgba(59,130,246,0.1); color: #1d4ed8; } /* approved=blue */
.status-pill-borrowed { background: rgba(13,159,122,0.1); color: #0D9F7A; } /* borrowed=teal */
.status-pill-returned { background: rgba(16,185,129,0.1); color: #047857; } /* returned=green */
.status-pill-rejected { background: rgba(239,68,68,0.1); color: #b91c1c; } /* rejected=red */

/* Rounded active teal Pagination override */
.pagination-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px 20px;
  border-top: 1px solid #f3f4f6;
  background: #fff;
  font-size: 0.8rem;
}
.pag-nav {
  display: inline-flex;
  gap: 6px;
}
.pag-nav a, .pag-nav span {
  width: 32px;
  height: 32px;
  border-radius: 50%; /* rounded pagination links */
  display: flex;
  align-items: center;
  justify-content: center;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.78rem;
  transition: all 0.2s ease;
  border: 1px solid #e5e7eb;
  background: #fff;
  color: var(--muted);
}
.pag-nav a:hover {
  background: #f9fafb;
  border-color: #cbd5e1;
  color: var(--text);
}
.pag-nav .active-page {
  background: #0D9F7A !important; /* aktif teal */
  color: #fff !important;
  border-color: #0D9F7A !important;
}

/* Modals design */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 1000;
  background: rgba(10,22,40,0.5);
  backdrop-filter: blur(4px);
  display: none;
  align-items: center;
  justify-content: center;
  padding: 16px;
}
.modal-overlay.show {
  display: flex;
}
.modal-card {
  background: #fff;
  border-radius: 0.75rem; /* rounded-xl */
  width: 100%;
  max-width: 440px;
  box-shadow: 0 20px 25px -5px rgba(0,0,0,0.15);
  overflow: hidden;
  animation: modalScaleUp 0.25s ease-out;
}
@keyframes modalScaleUp {
  from { transform: scale(0.95); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}
.modal-card-header {
  padding: 16px 20px;
  background: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-card-title {
  font-weight: 700;
  font-size: 0.95rem;
  color: var(--navy);
}
.modal-card-close {
  background: none;
  border: none;
  font-size: 1.25rem;
  cursor: pointer;
  color: var(--muted);
  line-height: 1;
}
.modal-card-body {
  padding: 20px;
}
.modal-card-footer {
  padding: 14px 20px;
  background: #f9fafb;
  border-top: 1px solid #e5e7eb;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}
.textarea-styled {
  width: 100%;
  background: #f9fafb; /* bg-gray-50 */
  border: 1px solid #e5e7eb; /* border-gray-200 */
  border-radius: 0.5rem; /* rounded-lg */
  padding: 10px 14px;
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  resize: none;
  height: 100px;
  color: var(--text);
  outline: none;
  transition: border-color 0.15s;
}
.textarea-styled:focus {
  border-color: #0D9F7A;
  background: #fff;
}
</style>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  1. HEADER                                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="borrow-header-row">
  <h1 class="borrow-title">Manajemen Peminjaman</h1>
  
  {{-- Tombol + Input Peminjaman --}}
  <a href="{{ route('admin.borrowings.create') }}" class="btn-primary-themed">
    <i class="ti ti-plus"></i> Input Peminjaman
  </a>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  2. FILTER BAR (card)                                      --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="filter-card">
  <form method="GET" action="{{ route('admin.borrowings.index') }}" id="filterForm">
    <div class="filter-grid">
      
      {{-- Search Peminjam --}}
      <div class="f-group">
        <label class="f-label">Cari Peminjam</label>
        <div class="f-input-wrapper">
          <i class="ti ti-search"></i>
          <input type="text" name="search" class="f-input" value="{{ request('search') }}" placeholder="Cari nama peminjam...">
        </div>
      </div>

      {{-- Select Filter Hari --}}
      <div class="f-group">
        <label class="f-label">Hari</label>
        <div class="f-input-wrapper">
          <i class="ti ti-calendar-event"></i>
          <select name="day" class="f-input f-select">
            <option value="all" {{ request('day') === 'all' || !request('day') ? 'selected' : '' }}>Semua Hari</option>
            <option value="Senin" {{ request('day') === 'Senin' ? 'selected' : '' }}>Senin</option>
            <option value="Selasa" {{ request('day') === 'Selasa' ? 'selected' : '' }}>Selasa</option>
            <option value="Rabu" {{ request('day') === 'Rabu' ? 'selected' : '' }}>Rabu</option>
            <option value="Kamis" {{ request('day') === 'Kamis' ? 'selected' : '' }}>Kamis</option>
            <option value="Jumat" {{ request('day') === 'Jumat' ? 'selected' : '' }}>Jumat</option>
          </select>
        </div>
      </div>

      {{-- Date range picker --}}
      <div class="f-group">
        <label class="f-label">Dari Tanggal</label>
        <div class="f-input-wrapper">
          <i class="ti ti-calendar"></i>
          <input type="date" name="start_date" class="f-input" value="{{ request('start_date') }}">
        </div>
      </div>

      <div class="f-group">
        <label class="f-label">Sampai Tanggal</label>
        <div class="f-input-wrapper">
          <i class="ti ti-calendar"></i>
          <input type="date" name="end_date" class="f-input" value="{{ request('end_date') }}">
        </div>
      </div>

      {{-- Select Status --}}
      <div class="f-group">
        <label class="f-label">Status</label>
        <div class="f-input-wrapper">
          <i class="ti ti-bell"></i>
          <select name="status" class="f-input f-select">
            <option value="all" {{ request('status') === 'all' || !request('status') ? 'selected' : '' }}>Semua Status</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="late" {{ request('status') === 'late' ? 'selected' : '' }}>Late (Terlambat)</option>
          </select>
        </div>
      </div>

      {{-- Filter and Reset Actions --}}
      <div class="filter-actions">
        <button type="submit" class="btn-filter-submit">
          <i class="ti ti-filter"></i> Filter
        </button>
        <a href="{{ route('admin.borrowings.index') }}" class="btn-filter-reset">
          Reset
        </a>
      </div>

    </div>
  </form>
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  3. INFO RINGKAS DI BAWAH FILTER                            --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="pills-bar">
  @foreach($borrowingsByDay as $dayData)
    @php
      $isActive = (request('day') === $dayData->day);
      $toggleDay = $isActive ? 'all' : $dayData->day;
      $url = route('admin.borrowings.index', array_merge(request()->except('day', 'page'), ['day' => $toggleDay]));
    @endphp
    <a href="{{ $url }}" class="pill-day-link @if($isActive) active @endif">
      <span class="pill-dot"></span>
      {{ $dayData->day }} ({{ $dayData->total }})
    </a>
  @endforeach
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  4. TABEL PEMINJAMAN (card)                                --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<section class="tbl-card">
  <div class="tbl-responsive">
    @if($borrowings->isEmpty())
      <div style="text-align: center; padding: 50px 20px; color: var(--muted);">
        <i class="ti ti-clipboard-off" style="font-size: 3rem; margin-bottom: 12px; display: block; opacity: 0.5;"></i>
        Tidak ada transaksi peminjaman yang ditemukan.
      </div>
    @else
      <table class="tbl-custom">
        <thead>
          <tr>
            <th style="width: 40px; text-align: center;">#</th>
            <th>Nama Peminjam</th>
            <th>Laptop</th>
            <th>Keperluan</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Status</th>
            <th style="text-align: center; width: 220px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($borrowings as $i => $b)
            @php
              $isOverdue = $b->isLate();
            @endphp
            <tr class="@if($isOverdue) row-late @endif">
              <td style="text-align: center; color: var(--muted); font-weight: 600;">
                {{ $borrowings->firstItem() + $i }}
              </td>
              <td>
                <div class="borrower-info">
                  <div class="borrower-avatar">
                    {{ strtoupper(substr($b->borrower_name ?? 'U', 0, 2)) }}
                  </div>
                  <div>
                    <div style="font-weight: 600;">{{ $b->borrower_name ?? 'N/A' }}</div>
                    <div style="font-size: 0.72rem; color: var(--muted);">
                      {{ $b->user ? ($b->user->kelas ?? 'Mahasiswa') : 'Umum' }}
                    </div>
                  </div>
                </div>
              </td>
              <td>
                <div class="laptop-info">
                  <div class="laptop-icon-box">
                    @if($b->laptop && $b->laptop->image)
                      <img src="{{ asset('storage/' . $b->laptop->image) }}" alt="Laptop thumbnail">
                    @else
                      <i class="ti ti-device-laptop"></i>
                    @endif
                  </div>
                  <div>
                    <div style="font-weight: 600;">{{ $b->laptop->brand ?? 'N/A' }}</div>
                    <div style="font-size: 0.72rem; color: var(--muted);">{{ $b->laptop->model ?? 'N/A' }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $b->purpose }}</td>
              <td>{{ $b->borrow_date->format('d M Y') }}</td>
              <td>
                <div style="font-weight: 600; @if($isOverdue) color: var(--red); @endif">
                  {{ $b->return_date->format('d M Y') }}
                </div>
                @if($isOverdue)
                  <div style="font-size: 0.68rem; color: var(--red); font-weight: 600; text-transform: uppercase;">
                    <i class="ti ti-alert-triangle"></i> Terlambat
                  </div>
                @endif
              </td>
              <td>
                @if($b->status === 'pending')
                  <span class="status-pill status-pill-pending">Pending</span>
                @elseif($b->status === 'approved')
                  <span class="status-pill status-pill-approved">Approved</span>
                @elseif($b->status === 'borrowed')
                  <span class="status-pill status-pill-borrowed">Borrowed</span>
                @elseif($b->status === 'returned')
                  <span class="status-pill status-pill-returned">Returned</span>
                @elseif($b->status === 'rejected')
                  <span class="status-pill status-pill-rejected">Rejected</span>
                @else
                  <span class="status-pill status-pill-pending">{{ ucfirst($b->status) }}</span>
                @endif
              </td>
              <td>
                <div class="btn-group-action" style="justify-content: center;">
                  @if($b->status === 'pending')
                    {{-- Quick Approve --}}
                    <form method="POST" action="{{ route('admin.borrowings.approve', $b->id) }}" style="display:inline;">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="btn-act btn-act-approve" title="Setujui Peminjaman">
                        <i class="ti ti-check"></i> Approve
                      </button>
                    </form>
                    
                    {{-- Quick Reject --}}
                    <button type="button" class="btn-act btn-act-reject" onclick="openRejectModal({{ $b->id }}, '{{ $b->borrower_name }}')" title="Tolak Peminjaman">
                      <i class="ti ti-x"></i> Reject
                    </button>
                  @endif
                  
                  {{-- Detail Link --}}
                  <a href="{{ route('admin.borrowings.show', $b->id) }}" class="btn-act btn-act-detail" title="Detail">
                    <i class="ti ti-eye"></i> Detail
                  </a>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  5. PAGINATION (rounded, aktif teal)                        --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  @if($borrowings->hasPages())
    <div class="pagination-container">
      <div style="color: var(--muted); font-weight: 500;">
        Menampilkan {{ $borrowings->firstItem() }} - {{ $borrowings->lastItem() }} dari {{ $borrowings->total() }} transaksi
      </div>
      <nav class="pag-nav">
        {{-- Previous Page --}}
        @if ($borrowings->onFirstPage())
          <span style="opacity: 0.4; pointer-events: none;"><i class="ti ti-chevron-left"></i></span>
        @else
          <a href="{{ $borrowings->previousPageUrl() }}"><i class="ti ti-chevron-left"></i></a>
        @endif

        {{-- Pages Range --}}
        @foreach ($borrowings->getUrlRange(1, $borrowings->lastPage()) as $page => $url)
          @if ($page == $borrowings->currentPage())
            <span class="active-page">{{ $page }}</span>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next Page --}}
        @if ($borrowings->hasMorePages())
          <a href="{{ $borrowings->nextPageUrl() }}"><i class="ti ti-chevron-right"></i></a>
        @else
          <span style="opacity: 0.4; pointer-events: none;"><i class="ti ti-chevron-right"></i></span>
        @endif
      </nav>
    </div>
  @endif
</section>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{--  MODAL PENOLAKAN PEMINJAMAN                                 --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div class="modal-overlay" id="rejectionModalOverlay">
  <div class="modal-card">
    <div class="modal-card-header">
      <h3 class="modal-card-title">Tolak Peminjaman Laptop</h3>
      <button class="modal-card-close" onclick="closeRejectModal()">&times;</button>
    </div>
    <form id="rejectionForm" method="POST" action="">
      @csrf
      @method('PATCH')
      <div class="modal-card-body">
        <p style="margin-bottom: 16px; font-size: 0.82rem; color: var(--muted); line-height: 1.4;">
          Anda akan menolak permohonan peminjaman laptop dari peminjam <strong id="rejectionTargetName" style="color: var(--text);"></strong>. Masukkan alasan penolakan di bawah ini:
        </p>
        
        <div style="margin-bottom: 16px;">
          <label class="f-label" for="admin_note" style="display:block; margin-bottom:6px;">Alasan Penolakan</label>
          <textarea id="admin_note" name="admin_note" class="textarea-styled" placeholder="Masukkan alasan penolakan, misal: Stok laptop unit ini sedang maintenance..." required></textarea>
        </div>
      </div>
      <div class="modal-card-footer">
        <button type="button" class="btn-styled-secondary" style="background:#f3f4f6; color:var(--muted); border:none; padding:8px 16px; border-radius:0.5rem; cursor:pointer;" onclick="closeRejectModal()">Batal</button>
        <button type="submit" class="btn-primary-themed" style="background: var(--red); color: white; padding: 8px 16px; border-radius:0.5rem; cursor:pointer;">Tolak Peminjaman</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
// --- Rejection Modal Management ---
function openRejectModal(borrowingId, borrowerName) {
  var form = document.getElementById('rejectionForm');
  form.action = '/admin/borrowings/' + borrowingId + '/reject';
  
  document.getElementById('rejectionTargetName').textContent = borrowerName;
  document.getElementById('rejectionModalOverlay').classList.add('show');
  document.getElementById('admin_note').focus();
}

function closeRejectModal() {
  document.getElementById('rejectionModalOverlay').classList.remove('show');
}
</script>
@endpush
@endsection
