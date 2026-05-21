@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  SECTION 1 — BANNER SELAMAT DATANG                         --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div class="rounded-2xl bg-[#0A1628] px-7 py-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
      <h1 class="text-white text-xl font-semibold">Selamat datang, {{ auth()->user()->name }}!</h1>
      <p class="text-[#9FE1CB] text-sm flex items-center gap-2 mt-1">
        <i class="ti ti-school text-[13px]"></i>
        <span>Kelas {{ auth()->user()->kelas ?? 'Umum' }}  ·  Sistem Peminjaman Laptop UNIBI</span>
      </p>
    </div>
    <div>
      <a href="{{ route('user.laptops.index') }}" class="bg-[#0D9F7A] text-white text-sm font-medium px-5 py-2.5 rounded-lg hover:bg-[#0b8a6a] transition flex items-center gap-2">
        <i class="ti ti-device-laptop text-base"></i>
        <span>Pinjam Laptop Sekarang</span>
      </a>
    </div>
  </div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  SECTION 2 — STAT CARDS                                     --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    
    <!-- Card 1 — Sedang Dipinjam -->
    <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center gap-4">
      <div class="w-[42px] h-[42px] bg-[#E1F5EE] rounded-xl flex items-center justify-center flex-shrink-0">
        <i class="ti ti-device-laptop text-[#0D9F7A] text-xl"></i>
      </div>
      <div>
        <div class="text-2xl font-semibold text-gray-900">{{ $activeBorrowings }}</div>
        <div class="text-xs text-gray-500 mt-1">Sedang dipinjam</div>
      </div>
    </div>

    <!-- Card 2 — Menunggu Konfirmasi -->
    <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center gap-4">
      <div class="w-[42px] h-[42px] bg-[#FAEEDA] rounded-xl flex items-center justify-center flex-shrink-0">
        <i class="ti ti-clock text-[#BA7517] text-xl"></i>
      </div>
      <div>
        <div class="text-2xl font-semibold text-gray-900">{{ $pendingBorrowings }}</div>
        <div class="text-xs text-gray-500 mt-1">Menunggu konfirmasi</div>
      </div>
    </div>

    <!-- Card 3 — Total Peminjaman -->
    <div class="bg-white border border-gray-100 rounded-xl p-5 flex items-center gap-4">
      <div class="w-[42px] h-[42px] bg-[#E6F1FB] rounded-xl flex items-center justify-center flex-shrink-0">
        <i class="ti ti-history text-[#185FA5] text-xl"></i>
      </div>
      <div>
        <div class="text-2xl font-semibold text-gray-900">{{ $totalBorrowings }}</div>
        <div class="text-xs text-gray-500 mt-1">Total peminjaman</div>
      </div>
    </div>

  </div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  SECTION 3 — PEMINJAMAN AKTIF                              --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  @if($activeLoan)
    <div class="text-xs font-medium text-gray-400 tracking-widest mb-2">PEMINJAMAN AKTIF</div>
    
    <div class="bg-white border border-gray-100 rounded-xl p-5 mb-6">
      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
          <div class="w-[44px] h-[44px] bg-[#E1F5EE] rounded-xl flex items-center justify-center flex-shrink-0">
            <i class="ti ti-device-laptop text-[#0D9F7A] text-xl"></i>
          </div>
          <div class="flex-1 min-w-0">
            <h3 class="text-sm font-medium text-gray-900">{{ $activeLoan->laptop->brand }} {{ $activeLoan->laptop->model }}</h3>
            <div class="flex items-center gap-1.5 text-xs text-gray-500 mt-1">
              <i class="ti ti-calendar text-sm"></i>
              <span>{{ $activeLoan->borrow_date->format('d M Y') }}</span>
              <i class="ti ti-arrow-right text-xs"></i>
              <span>{{ $activeLoan->return_date->format('d M Y') }}</span>
            </div>
          </div>
        </div>
        <div>
          @if($activeLoan->status === 'approved')
            <span class="bg-[#E1F5EE] text-[#0F6E56] text-xs font-medium px-3 py-1 rounded-full">Disetujui</span>
          @else
            <span class="bg-[#E1F5EE] text-[#0F6E56] text-xs font-medium px-3 py-1 rounded-full">Dipinjam</span>
          @endif
        </div>
      </div>

      {{-- Progress Bar --}}
      @php
        $totalDays = $activeLoan->borrow_date->diffInDays($activeLoan->return_date) ?: 1;
        $elapsedDays = $activeLoan->borrow_date->diffInDays(now()) ?: 0;
        $pct = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));

        $daysLeft = now()->diffInDays($activeLoan->return_date, false);
        if ($daysLeft < 0) {
            $fillColor = 'bg-[#EF4444]'; // red jika sudah lewat
            $sisaText = 'Terlambat ' . abs($daysLeft) . ' hari';
        } elseif ($daysLeft <= 2) {
            $fillColor = 'bg-[#F59E0B]'; // amber jika sisa 1-2 hari
            $sisaText = 'Sisa ' . $daysLeft . ' hari';
        } else {
            $fillColor = 'bg-[#0D9F7A]'; // teal jika sisa > 2 hari
            $sisaText = 'Sisa ' . $daysLeft . ' hari';
        }
      @endphp
      <div class="mt-3">
        <div class="flex justify-between text-xs text-gray-400 mb-1.5">
          <span class="truncate pr-4">Keperluan: {{ $activeLoan->purpose }}</span>
          <span class="flex-shrink-0 font-medium text-gray-500">{{ $sisaText }}</span>
        </div>
        <div class="h-1.5 bg-gray-100 rounded-full overflow-hidden">
          <div class="h-full {{ $fillColor }} rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
        </div>
      </div>
    </div>
  @endif

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  SECTION 4 — LAPTOP TERSEDIA                                --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div class="flex justify-between items-center mb-3">
    <div class="flex items-center gap-2">
      <i class="ti ti-device-laptop text-[#0D9F7A] text-base"></i>
      <span class="text-sm font-medium text-gray-900">Laptop tersedia</span>
    </div>
    <a href="{{ route('user.laptops.index') }}" class="text-[#0D9F7A] text-xs hover:underline flex items-center gap-1 text-decoration-none">
      <span>Lihat semua</span>
      <i class="ti ti-arrow-right text-[12px]"></i>
    </a>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($availableLaptops as $laptop)
      <div class="bg-white border border-gray-100 rounded-xl overflow-hidden hover:border-[#0D9F7A] transition-colors cursor-pointer flex flex-col justify-between"
           onclick="window.location='{{ $laptop->status === 'tersedia' ? route('user.laptops.show', $laptop) : '#' }}'">
        
        <!-- GAMBAR AREA -->
        <div class="h-28 bg-gray-50 flex items-center justify-center relative">
          <i class="ti ti-device-laptop text-[#0D9F7A] text-4xl"></i>
          
          <div class="absolute top-2.5 right-2.5">
            @if($laptop->status === 'tersedia')
              <span class="bg-[#E1F5EE] text-[#0F6E56] text-[10px] font-medium px-2 py-0.5 rounded-full">Tersedia</span>
            @else
              <span class="bg-gray-100 text-gray-500 text-[10px] font-medium px-2 py-0.5 rounded-full">Dipinjam</span>
            @endif
          </div>
        </div>

        <!-- BODY -->
        <div class="px-4 pt-3 pb-4 flex flex-col flex-1">
          <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-0.5">
            {{ strtoupper($laptop->brand) }}
          </div>
          <h4 class="text-sm font-medium text-gray-900 mb-3">
            {{ $laptop->model }}
          </h4>
          
          @if($laptop->status === 'tersedia')
            <a href="{{ route('user.laptops.show', $laptop) }}" class="bg-[#0D9F7A] text-white hover:bg-[#0b8a6a] rounded-lg text-xs font-medium py-2 flex items-center justify-center gap-1.5 mt-auto text-decoration-none" onclick="event.stopPropagation();">
              <i class="ti ti-plus text-[13px]"></i>
              <span>Pinjam Sekarang</span>
            </a>
          @else
            <button type="button" class="bg-gray-100 text-gray-400 cursor-not-allowed rounded-lg text-xs font-medium py-2 flex items-center justify-center gap-1.5 mt-auto w-full border-none" disabled onclick="event.stopPropagation();">
              <span>Sedang Dipinjam</span>
            </button>
          @endif
        </div>

      </div>
    @endforeach
  </div>

  {{-- FOOTER SECTION --}}
  <div class="text-gray-400 text-xs text-center mt-10 pb-2">
    Copyright © 2026 UNIBI · LendLaptop
  </div>

</div>
@endsection
